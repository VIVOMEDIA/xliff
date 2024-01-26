<?php

namespace VIVOMEDIA\XliffParser\Domain\V12;

class Attributes
{
    public function __construct(
        protected array $attributes = [],
    ) {

    }

    public function all($namespace = null): array
    {
        return $this->attributes[$namespace] ?? [];
    }

    public function get($key, $namespace = null): mixed
    {
        return $this->attributes[$namespace][$key] ?? null;
    }
}