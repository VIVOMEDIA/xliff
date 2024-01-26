<?php

namespace VIVOMEDIA\XliffParser\Writer\V12;

use VIVOMEDIA\XliffParser\Domain\V12\Document;
use VIVOMEDIA\XliffParser\Domain\V12\File;
use VIVOMEDIA\XliffParser\Domain\V12\Group;
use VIVOMEDIA\XliffParser\Domain\V12\Source;
use VIVOMEDIA\XliffParser\Domain\V12\Target;
use VIVOMEDIA\XliffParser\Domain\V12\TransUnit;

class XliffWriter
{
    public function write(Document $document, string $path): void
    {
        $documentXml = $this->generateXml($document);

        $dom = dom_import_simplexml($documentXml)->ownerDocument;
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->save($path);
    }

    public function output(Document $document): string
    {
        $documentXml = $this->generateXml($document);

        $dom = dom_import_simplexml($documentXml)->ownerDocument;
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        return $dom->saveXML();
    }

    protected function generateXml(Document $document)
    {
        $documentXml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><xliff />', LIBXML_COMPACT);
        $documentXml->addAttribute('xmlns', 'urn:oasis:names:tc:xliff:document:1.2');
        $documentXml->addAttribute('version', '1.2');

        foreach ($document->getFiles() as $file) {
            $fileXml = $this->addFileToXml($documentXml, $file);
            $bodyXml = $fileXml->addChild('body');

            foreach ($file->getBodyItems() as $bodyItem) {
                if ($bodyItem instanceof TransUnit) {
                    $transUnitXml = $this->addTransUnitToXml($bodyXml, $bodyItem);
                    $this->addSourceToXml($transUnitXml, $bodyItem->getSource());
                    $this->addTargetToXml($transUnitXml, $bodyItem->getTarget());
                } elseif ($bodyItem instanceof Group) {
                    $groupXml = $this->addGroupToXml($bodyXml, $bodyItem);
                    foreach ($bodyItem->getTransUnits() as $transUnit) {
                        $this->addTransUnitToXml($groupXml, $transUnit);
                    }
                }
            }
        }
        return $documentXml;
    }

    private function addFileToXml(?\SimpleXMLElement $xml, File $file): \SimpleXMLElement
    {
        $fileXml = $xml->addChild('file');
        foreach ($file->getAttributes()->all() as $key => $value) {
            $fileXml->addAttribute($key, $value);
        }
        foreach ($file->getAttributes()->all('xml') as $key => $value) {
            $fileXml->addAttribute("xml:" . $key, $value, "xml");
        }

        return $fileXml;
    }

    private function addTransUnitToXml(?\SimpleXMLElement $xml, TransUnit $transUnit): \SimpleXMLElement
    {
        $transUnitXml = $xml->addChild('trans-unit');
        foreach ($transUnit->getAttributes()->all() as $key => $value) {
            $transUnitXml->addAttribute($key, $value);
        }
        foreach ($transUnit->getAttributes()->all('xml') as $key => $value) {
            $transUnitXml->addAttribute("xml:" . $key, $value, "xml");
        }

        return $transUnitXml;
    }

    private function addGroupToXml(?\SimpleXMLElement $xml, Group $group): \SimpleXMLElement
    {
        $groupXml = $xml->addChild('group');
        foreach ($group->getAttributes()->all() as $key => $value) {
            $groupXml->addAttribute($key, $value);
        }
        foreach ($group->getAttributes()->all('xml') as $key => $value) {
            $groupXml->addAttribute("xml:" . $key, $value, "xml");
        }

        return $groupXml;
    }

    private function addSourceToXml(?\SimpleXMLElement $xml, Source $source): \SimpleXMLElement
    {
        $sourceXml = $xml->addChild('source', htmlspecialchars($source->getContent()));
        foreach ($source->getAttributes()->all() as $key => $value) {
            $sourceXml->addAttribute($key, $value);
        }
        foreach ($source->getAttributes()->all('xml') as $key => $value) {
            $sourceXml->addAttribute("xml:" . $key, $value, "xml");
        }

        return $sourceXml;
    }

    private function addTargetToXml(?\SimpleXMLElement $xml, Target $target): \SimpleXMLElement
    {
        $targetXml = $xml->addChild('target', htmlspecialchars($target->getContent()));
        foreach ($target->getAttributes()->all() as $key => $value) {
            $targetXml->addAttribute($key, $value);
        }
        foreach ($target->getAttributes()->all('xml') as $key => $value) {
            $targetXml->addAttribute("xml:" . $key, $value, "xml");
        }

        return $targetXml;
    }
}
