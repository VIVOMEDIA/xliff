<?php

namespace VIVOMEDIA\XliffParser\Domain\V12;

class Group extends BodyItem
{
    public function __construct(
        /** @var array<TransUnit> $transUnits */
        protected array $transUnits = [],
        protected ?Attributes $attributes = new Attributes(),
    ) {
    }

    public function addTransUnit(TransUnit $transUnit)
    {
        $this->transUnits[] = $transUnit;
    }

    public function getTransUnits(): array
    {
        return $this->transUnits;
    }

    public function getAttributes(): Attributes
    {
        return $this->attributes;
    }

}
