<?php

namespace VIVOMEDIA\XliffParser\Domain\V12;

class Source
{
    public function __construct(
        protected string $content,
        protected ?Attributes $attributes = new Attributes(),
    ) {

    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAttributes(): Attributes
    {
        return $this->attributes;
    }
}
