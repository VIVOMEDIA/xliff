[![Latest Stable Version](https://poser.pugx.org/vivomedia/xliff/v/stable)](https://packagist.org/packages/vivomedia/xliff)
[![Total Downloads](https://poser.pugx.org/vivomedia/xliff/downloads)](https://packagist.org/packages/vivomedia/xliff)
[![License](https://poser.pugx.org/vivomedia/xliff/license)](https://packagist.org/packages/vivomedia/xliff)

# VIVOMEDIA Xliff Reader and Writer
Simple Xliff Reader and Writer. Currently only Xliff Version 1.2.

## Install
```
composer require vivomedia/xliff
```


## How to use

### Reader
```php
use VIVOMEDIA\XliffParser\Domain\V12\TransUnit;
use VIVOMEDIA\XliffParser\Reader\V12\XliffReader;

$reader = new XliffReader();
$document = $reader->read('/path/to/file.xlf');


foreach ($read->getFiles() as $file) {
    foreach ($file->getBodyItems() as $bodyItem) {
        if ($bodyItem instanceof TransUnit) {
            printf(
                "'%s' | '%s' => '%s'\n",
                $bodyItem->getAttributes()->get('id'),
                $bodyItem->getSource()->getContent(),
                $bodyItem->getTarget()?->getContent(),
            );
        }
    }
}

```
### Writer
```php
use VIVOMEDIA\XliffParser\Domain\V12\Attributes;
use VIVOMEDIA\XliffParser\Domain\V12\Document;
use VIVOMEDIA\XliffParser\Domain\V12\File;
use VIVOMEDIA\XliffParser\Domain\V12\Source;use VIVOMEDIA\XliffParser\Domain\V12\Target;use VIVOMEDIA\XliffParser\Domain\V12\TransUnit;
use VIVOMEDIA\XliffParser\Writer\V12\XliffWriter;

$b = new XliffWriter();
$b->write($read, $pathES);

$sourceAttributes = new Attributes(["xml" => ['lang' => "de"]]);
$source = new Source("Bitte übersetzen", $sourceAttributes);

$targetAttributes = new Attributes([null => ['state' => 'translated'], "xml" => ['lang' => "en"]]);
$target = new Target("Please translate", $targetAttributes);

$transUnitAttributes = new Attributes([null => ['id' => "my.identifier", "approved" => "yes"]]);
$transUnitItem = new TransUnit($source, $target, $transUnitAttributes);

$fileAttributes = new Attributes([null => ['product-name' => "MyProduct", "source-language" => "de", "target-language" => "en"]]);
$file = new File([$transUnitItem], $fileAttributes);

$document = new Document([$file]);

$writer = new XliffWriter();
$writer->write($document, '/path/to/other.xlf'); 
```
Result
```xml
<?xml version="1.0" encoding="UTF-8"?>
<xliff xmlns="urn:oasis:names:tc:xliff:document:1.2" version="1.2">
    <file product-name="MyProduct" source-language="de" target-language="en">
        <body>
            <trans-unit id="my.identifier" approved="yes">
                <source xml:lang="de">Bitte übersetzen</source>
                <target state="translated" xml:lang="en">Please translate</target>
            </trans-unit>
        </body>
    </file>
</xliff>

```
