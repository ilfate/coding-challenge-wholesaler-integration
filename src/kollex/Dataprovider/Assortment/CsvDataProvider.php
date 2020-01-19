<?php declare(strict_types=1);

namespace kollex\Dataprovider\Assortment;

use kollex\Dataprovider\Exception\ErrorParsingFileException;
use kollex\Entity\Product;
use kollex\Entity\ProductField\BaseProductPackaging;
use kollex\Entity\ProductField\BaseProductUnit;
use kollex\Entity\ProductField\Packaging;

class CsvDataProvider extends AbstractFileDataProvider
{
    const CSV_FIELD_ID = "id";
    const CSV_FIELD_GTIN = "ean";
    const CSV_FIELD_MANUFACTURER = "manufacturer";
    const CSV_FIELD_NAME = "product";
    const CSV_FIELD_PACKAGING = "packaging product";
    const CSV_FIELD_BASE_PRODUCT_PACKAGING = "packaging unit";
    const CSV_FIELD_BASE_PRODUCT_AMOUNT = "amount per unit";

    const VALUE_MAP_PACKAGING = [
        'case 12' => Packaging::CA,
        'case 20' => Packaging::CA,
        'box 6' => Packaging::BX,
        'single' => Packaging::BO,
    ];
    const VALUE_MAP_BASE_PRODUCT_PACKAGING = [
        'bottle' => BaseProductPackaging::BO,
        'can' => BaseProductPackaging::CN,
    ];

    protected function parseFileIntoProducts(string $fileContent)
    {
        $products = [];
        $lines = explode("\n", $fileContent);
        // filter out empty lines
        $lines = array_filter($lines, function($line) { return (bool)$line; });
        $productsArray = array_map(
            function($line) {
                return str_getcsv($line, ';');
            },
            $lines);
        array_walk($productsArray, function(&$a) use ($productsArray) {
            $a = array_combine($productsArray[0], $a);
        });
        array_shift($productsArray);
        foreach ($productsArray as $item) {
            $products[] = new Product(
                $item[self::CSV_FIELD_ID],
                $item[self::CSV_FIELD_MANUFACTURER],
                $item[self::CSV_FIELD_NAME],
                $this->parsePackaging($item),
                $this->parseBaseProductPackaging($item),
                $this->parseBaseProductUnit($item),
                $this->parseBaseProductAmount($item),
                $this->parseBaseProductQuantity($item),
                $item[self::CSV_FIELD_GTIN] ?? ""
            );
        }
        return $products;
    }

    private function parsePackaging($productRawData): Packaging
    {
        $value = $productRawData[self::CSV_FIELD_PACKAGING];
        if (!isset(self::VALUE_MAP_PACKAGING[$value])) {
            throw new ErrorParsingFileException("Packaging value $value is unknown");
        }
        $mappedValue = self::VALUE_MAP_PACKAGING[$value];
        return Packaging::$mappedValue();
    }

    private function parseBaseProductPackaging($productRawData): BaseProductPackaging
    {
        $value = $productRawData[self::CSV_FIELD_BASE_PRODUCT_PACKAGING];
        if (!isset(self::VALUE_MAP_BASE_PRODUCT_PACKAGING[$value])) {
            throw new ErrorParsingFileException("Base Product Packaging value $value is unknown");
        }
        $mappedValue = self::VALUE_MAP_BASE_PRODUCT_PACKAGING[$value];
        return BaseProductPackaging::$mappedValue();
    }

    private function parseBaseProductAmount($productRawData): float
    {
        $value = $productRawData[self::CSV_FIELD_BASE_PRODUCT_AMOUNT];
        if (strpos($value, 'l') !== false) $value = substr($value, 0, -1);
        return (float) $value;
    }

    private function parseBaseProductUnit($productRawData): BaseProductUnit
    {
        $value = $productRawData[self::CSV_FIELD_BASE_PRODUCT_AMOUNT];
        if (strpos($value, 'l') !== false) return BaseProductUnit::LT();
        if (strpos($value, 'g') !== false) return BaseProductUnit::GR();
        return BaseProductUnit::LT();
    }

    private function parseBaseProductQuantity($productRawData): int
    {
        $value = $productRawData[self::CSV_FIELD_NAME];
        preg_match('/\\w,\\s(\\d+)\\s*/', $value, $matches);
        if ($matches && !empty($matches[1])) return (int) $matches[1];
        return 1;
    }
}