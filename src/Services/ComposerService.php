<?php

declare(strict_types=1);

namespace Balt\Nuxalk\Services;

use Balt\Nuxalk\Models\Composer\InstalledPackage;
use Balt\Nuxalk\Models\Composer\RequiredPackage;

class ComposerService
{
    public function __construct(string $composerJson, string $composerLock)
    {
        $this->composerJson = $composerJson;
        $this->composerLock = $composerLock;
    }

    public function withJson(string $composerJson): self
    {
        $this->composerJson = $composerJson;
        return $this;
    }

    public function withLock(string $composerLock): self
    {
        $this->composerLock = $composerLock;
        return $this;
    }

    /**
     * @return array<RequiredPackage>
     */
    public function getRequiredPackages(): array
    {
        $json = json_decode(file_get_contents($this->composerJson), true);

        $packages = [];

        foreach ($json['require'] as $package => $constrain) {
            $packages[] = new RequiredPackage(package: $package, constrain: $constrain);
        }

        return $packages;
    }

    /**
     * @return array<InstalledPackage>
     */
    public function getInstalledPackages(): array
    {
        $json = json_decode(file_get_contents($this->composerLock), true);

        $packages = [];

        foreach ($json['packages'] as $package) {
            $packages[] = new InstalledPackage(package: $package['name'], installed: $package['version']);
        }

        return $packages;
    }
}
