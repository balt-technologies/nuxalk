<?php

namespace Tests\Services;

use Balt\Nuxalk\Services\VersionService;
use PHPUnit\Framework\TestCase;

class VersionServiceTest extends TestCase
{

    public function testCanSortVersionsSameMinor()
    {
        $versions = [
            '0.1.0',
            '0.2.0',
            '0.2.1',
        ];

        $constraint = '^0.2';

        $versionService = new VersionService();
        $version = $versionService->getNewestAvailableVersion($constraint, $versions);

        self::assertEquals('0.2.1', $version);

    }

    public function testCanSortVersionsOtherMinor()
    {
        $versions = [
            '0.1.0',
            '0.2.0',
            '0.3.0',
        ];

        $constraint = '^0.2';

        $versionService = new VersionService();
        $version = $versionService->getNewestAvailableVersion($constraint, $versions);

        self::assertEquals('0.2.0', $version);

    }

    public function testCanSortVersionsOtherMinorUnsorted()
    {
        $versions = [
            '0.2.0',
            '0.2.3',
            '0.2.2',
        ];

        $constraint = '^0.2';

        $versionService = new VersionService();
        $version = $versionService->getNewestAvailableVersion($constraint, $versions);

        self::assertEquals('0.2.3', $version);

    }

}