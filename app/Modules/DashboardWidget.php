<?php

namespace App\Modules;

class DashboardWidget
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public string $icon,
        public string $view,
        public int $width = 6,
        public $dataCallback = null,
        public bool $enabledByDefault = true,
    ) {}

    public function getData(): array
    {
        return $this->dataCallback
            ? call_user_func($this->dataCallback)
            : [];
    }
}
