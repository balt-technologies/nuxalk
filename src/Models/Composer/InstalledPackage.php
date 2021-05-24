<?php

declare(strict_types=1);

namespace Balt\Nuxalk\Models\Composer;

class InstalledPackage
{
    public function __construct(public string $package, public string $installed)
    {
    }
}
