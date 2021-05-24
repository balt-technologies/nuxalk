<?php

declare(strict_types=1);

namespace Balt\Nuxalk\Services;

use Composer\Semver\Semver;

class VersionService
{
    /**
     * @param array<string> $versions
     */
    public function getNewestAvailableVersion(string $constraint, array $versions): ?string
    {
        $versions = Semver::satisfiedBy($versions, $constraint);

        if (count($versions) > 0) {
            $sortedVersions = Semver::rsort($versions);

            $version = $sortedVersions[0];

            if (str_contains($version, '-')) {
                if (count($versions) > 1) {
                    return $sortedVersions[1];
                }

                return null;
            }

            return $version;
        }

        return null;
    }
}
