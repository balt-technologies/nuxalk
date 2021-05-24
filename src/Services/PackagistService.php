<?php

declare(strict_types=1);

namespace Balt\Nuxalk\Services;

use Packagist\Api\Client;
use Packagist\Api\Result\Package;

class PackagistService
{
    private Client $packagistApi;

    public function __construct(Client $packagistApi)
    {
        $this->packagistApi = $packagistApi;
    }

    /**
     * @param string $packageName
     * @return array<string>
     */
    public function getVersions(string $packageName): array
    {
        /** @var Package $package */
        $package = $this->packagistApi->get($packageName);

        return array_keys($package->getVersions());
    }
}
