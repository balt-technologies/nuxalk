<?php

declare(strict_types=1);

namespace Balt\Nuxalk\Services;

use Balt\Nuxalk\Models\CheckUpdateResult;
use Composer\Semver\Comparator;

class UpdateCheckService
{
    public function __construct(PackagistService $packagistService, VersionService $versionService)
    {
        $this->packagistService = $packagistService;
        $this->versionService = $versionService;
    }

    public function checkPackage(string $package, string $installed, string $constraint): ?CheckUpdateResult
    {
        $versions = $this->packagistService->getVersions($package);

        $latestAvailableVersion = $this->versionService->getNewestAvailableVersion($constraint, $versions);

        return new CheckUpdateResult(
            name: $package,
            installed: $installed,
            newest: $latestAvailableVersion,
            constrain: $constraint,
            updateable: Comparator::lessThan($installed, $latestAvailableVersion)
        );
    }
}
