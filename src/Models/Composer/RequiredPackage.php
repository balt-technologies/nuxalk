<?php

declare(strict_types=1);

namespace Balt\Nuxalk\Models\Composer;

class RequiredPackage implements \JsonSerializable
{
    public function __construct(public string $package, public string $constrain)
    {
    }

    public function jsonSerialize()
    {
        return [
            'package' => $this->package,
            'constrain' => $this->constrain,
        ];
    }
}
