<?php

declare(strict_types=1);

namespace Balt\Nuxalk\Services;

use Balt\Nuxalk\Models\CheckUpdateResult;

class PackageService
{
    public function __construct(
        private UpdateCheckService $updateCheckService
    ) {
    }

    /**
     * @return array<CheckUpdateResult>
     */
    public function check(string $composerJson, string $composerLock): array
    {
        $composerService = new ComposerService($composerJson, $composerLock);

        $installedPackages = $composerService->getInstalledPackages();
        $requiredPackages = $composerService->getRequiredPackages();

        $results = [];

        foreach ($requiredPackages as $requiredPackage) {
            $installedPackage = array_filter($installedPackages, static function ($package) use ($requiredPackage) {
                return $package->package === $requiredPackage->package;
            });

            if (count($installedPackage) === 0) {
                echo 'Skipped: '. $requiredPackage->package. PHP_EOL;

                continue;
            }

            $results[] = $this->updateCheckService->checkPackage(
                package: $requiredPackage->package,
                installed: array_shift($installedPackage)->installed,
                constraint: $requiredPackage->constrain
            );
        }

        return $results;
    }
}
