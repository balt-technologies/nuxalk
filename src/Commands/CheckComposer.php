<?php

declare(strict_types=1);

namespace Balt\Nuxalk\Commands;

use Balt\Nuxalk\Models\CheckUpdateResult;
use Balt\Nuxalk\Services\PackageService;
use Balt\Nuxalk\Services\PackagistService;
use Balt\Nuxalk\Services\UpdateCheckService;
use Balt\Nuxalk\Services\VersionService;
use Packagist\Api\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CheckComposer extends Command
{
    protected static $defaultName = 'check:composer';

    private PackageService $packageService;

    public function __construct(?string $name = null)
    {
        $this->packageService = new PackageService(
            new UpdateCheckService(
                new PackagistService(new Client()),
                new VersionService()
            )
        );

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Check a composer installation for updates')
            ->addArgument('composerJson', InputArgument::REQUIRED, 'path to composer.json')
            ->addArgument('composerLock', InputArgument::REQUIRED, 'path to composer.lock')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $results = $this->packageService->check(
            composerJson: realpath($input->getArgument('composerJson')),
            composerLock: realpath($input->getArgument('composerLock'))
        );

        $io = new SymfonyStyle($input, $output);

        $io->table(
            [
                'Package',
                'installed',
                'newest matching',
                'constraint',
            ],
            array_map(static function (CheckUpdateResult $result) {
                $values = array_values($result->jsonSerialize());

                if ($values[4] === true) {
                    $values[2] = '<fg=black;bg=yellow>'.$values[2].'</>';
                }
                unset($values[4]);

                return $values;
            }, $results)
        );

        return 0;
    }
}
