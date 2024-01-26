<?php

namespace VIVOMEDIA\XliffParser\Domain\V12;

class File
{
    public function __construct(
        /** @var array<BodyItem> $items */
        protected array $items = [],
        protected ?Attributes $attributes = new Attributes(),
    ) {

    }

    public function addBodyItem(BodyItem $item): void
    {
        $this->items[] = $item;
    }

    public function getBodyItems(): array
    {
        return $this->items;
    }

    public function getAttributes(): Attributes
    {
        return $this->attributes;
    }

}
