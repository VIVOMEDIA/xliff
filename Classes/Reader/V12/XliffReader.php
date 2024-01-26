<?php

namespace VIVOMEDIA\XliffParser\Reader\V12;

use VIVOMEDIA\XliffParser\Domain\V12\Attributes;
use VIVOMEDIA\XliffParser\Domain\V12\Document;
use VIVOMEDIA\XliffParser\Domain\V12\File;
use VIVOMEDIA\XliffParser\Domain\V12\Group;
use VIVOMEDIA\XliffParser\Domain\V12\Source;
use VIVOMEDIA\XliffParser\Domain\V12\Target;
use VIVOMEDIA\XliffParser\Domain\V12\TransUnit;

class XliffReader
{
    public function read($file): Document
    {
        $xml = simplexml_load_file($file);

        if ($xml->getName() === 'xliff' && $xml->version = '1.2') {
            $document = $this->getDocumentForNode($xml);
        } else {
            throw new \RuntimeException("Not a valid Xliff file in Version 1.2");
        }

        return $document;
    }

    private function xmlAttributesToAttributes(\SimpleXMLElement $bodyItemNode): Attributes
    {
        return new Attributes([
            null => ((array)$bodyItemNode->attributes())['@attributes'] ?? [],
            'xml' => ((array)$bodyItemNode->attributes('http://www.w3.org/XML/1998/namespace'))['@attributes'] ?? [],
        ]);
    }

    private function getDocumentForNode(\SimpleXMLElement $node): Document
    {
        $files = [];
        foreach ($node->children() as $fileNode) {
            if ($fileNode->getName() === 'file') {
                if ($fileNode->body) {
                    $files[] = $this->getFileForNode($fileNode);
                } else {
                    throw new \RuntimeException("Not a valid Xliff file in Version 1.2");
                }
            }
        }

        return new Document($files);
    }

    private function getFileForNode(\SimpleXMLElement $node): File
    {
        $items = [];
        foreach ($node->body->children() as $bodyItemNode) {
            if ($bodyItemNode->getName() == 'trans-unit') {
                $items[] = $this->getTransUnitForNode($bodyItemNode);
            } elseif ($bodyItemNode->getName() == 'group') {
                $items[] = $this->getGroupForNode($bodyItemNode);
            }
        }
        return new File($items, $this->xmlAttributesToAttributes($node));
    }

    private function getGroupForNode(\SimpleXMLElement $node): Group
    {
        $groupItems = [];
        foreach ($node->children() as $groupItemNode) {
            $groupItems[] = $this->getTransUnitForNode($groupItemNode);
        }
        return new Group($groupItems, $this->xmlAttributesToAttributes($node));
    }

    private function getTransUnitForNode(\SimpleXMLElement $node): TransUnit
    {
        $source = new Source(
            (string)$node->source,
            $this->xmlAttributesToAttributes($node->source)
        );

        $target = null;
        if ($node->target) {
            $target = new Target(
                (string)$node->target,
                $this->xmlAttributesToAttributes($node->target)
            );
        }

        return new TransUnit(
            $source,
            $target,
            $this->xmlAttributesToAttributes($node)
        );
    }
}
