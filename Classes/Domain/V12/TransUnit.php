<?php

namespace VIVOMEDIA\XliffParser\Domain\V12;

class TransUnit
{
    public function __construct(
        protected Source $source,
        protected ?Target $target = null,
        protected ?Attributes $attributes = new Attributes(),
    ) {

    }

    public function getSource(): Source
    {
        return $this->source;
    }

    public function getTarget(): ?Target
    {
        return $this->target;
    }

    public function getAttributes(): Attributes
    {
        return $this->attributes;
    }


}
