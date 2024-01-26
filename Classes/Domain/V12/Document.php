<?php

namespace VIVOMEDIA\XliffParser\Domain\V12;

class Document
{
    public function __construct(
        /** @var array<File> $files */
        protected array $files = [],
    ) {
    }

    public function addFile(File $file): void
    {
        $this->files[] = $file;
    }

    public function getFiles(): array
    {
        return $this->files;
    }
}
