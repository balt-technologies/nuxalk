<?php

declare(strict_types=1);

namespace Balt\Nuxalk\Models;

class CheckUpdateResult implements \JsonSerializable
{
    public function __construct(
        public string $name,
        public string $installed,
        public ?string $newest,
        public string $constrain,
        public bool $updateable
    ) {
    }

    public function isUpdateAvailable()
    {
        return $this->updateable;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'installed' => $this->installed,
            'newest' => $this->newest,
            'constrain' => $this->constrain,
            'updateable' => $this->updateable,
        ];
    }
}
