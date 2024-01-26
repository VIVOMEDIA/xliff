<?php

namespace VIVOMEDIA\XliffParser\Domain\V12;

class TransUnit extends BodyItem
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

    public function setTarget(Target $target): void
    {
        $this->target = $target;
    }

    public function getAttributes(): Attributes
    {
        return $this->attributes;
    }
}
