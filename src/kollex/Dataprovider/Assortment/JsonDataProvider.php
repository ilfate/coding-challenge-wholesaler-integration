<?php declare(strict_types=1);

namespace kollex\Dataprovider\Assortment;

use kollex\Dataprovider\Exception\ErrorParsingFileException;
use kollex\Entity\Product;
use kollex\Entity\ProductField\BaseProductPackaging;
use kollex\Entity\ProductField\BaseProductUnit;
use kollex\Entity\ProductField\Packaging;

class JsonDataProvider extends AbstractFileDataProvider
{
    const JSON_FIELD_ID = "PRODUCT_IDENTIFIER";
    const JSON_FIELD_GTIN = "EAN_CODE_GTIN";
    const JSON_FIELD_MANUFACTURER = "BRAND";
    const JSON_FIELD_NAME = "NAME";
    const JSON_FIELD_PACKAGING = "PACKAGE";
    const JSON_FIELD_BASE_PRODUCT_PACKAGING = "VESSEL";
    const JSON_FIELD_BASE_PRODUCT_AMOUNT = "LITERS_PER_BOTTLE";
    const JSON_FIELD_BASE_PRODUCT_QUANTITY = "BOTTLE_AMOUNT";

    const VALUE_MAP_PACKAGING = [
        'case' => Packaging::CA,
        'box' => Packaging::BX,
        'BOTTLE' => Packaging::BO,
    ];
    const VALUE_MAP_BASE_PRODUCT_PACKAGING = [
        'bottle' => BaseProductPackaging::BO,
        'can' => BaseProductPackaging::CN,
    ];

    protected function parseFileIntoProducts(string $fileContent)
    {
        $products = [];
        $productsArray = \json_decode($fileContent, true);
        foreach ($productsArray['data'] as $item) {
            $products[] = new Product(
                $item[self::JSON_FIELD_ID],
                $item[self::JSON_FIELD_MANUFACTURER],
                $item[self::JSON_FIELD_NAME],
                $this->parsePackaging($item),
                $this->parseBaseProductPackaging($item),
                BaseProductUnit::LT(),
                $this->parseBaseProductAmount($item),
                (int)$item[self::JSON_FIELD_BASE_PRODUCT_QUANTITY],
                $item[self::JSON_FIELD_GTIN] ?? ""
            );
        }
        return $products;
    }

    private function parsePackaging($productRawData): Packaging
    {
        $value = $productRawData[self::JSON_FIELD_PACKAGING];
        if (!isset(self::VALUE_MAP_PACKAGING[$value])) {
            throw new ErrorParsingFileException("Packaging value $value is unknown");
        }
        $mappedValue = self::VALUE_MAP_PACKAGING[$value];
        return Packaging::$mappedValue();
    }

    private function parseBaseProductPackaging($productRawData): BaseProductPackaging
    {
        $value = $productRawData[self::JSON_FIELD_BASE_PRODUCT_PACKAGING];
        if (!isset(self::VALUE_MAP_BASE_PRODUCT_PACKAGING[$value])) {
            throw new ErrorParsingFileException("Base Product Packaging value $value is unknown");
        }
        $mappedValue = self::VALUE_MAP_BASE_PRODUCT_PACKAGING[$value];
        return BaseProductPackaging::$mappedValue();
    }

    private function parseBaseProductAmount($productRawData): float
    {
        $value = $productRawData[self::JSON_FIELD_BASE_PRODUCT_AMOUNT];
        $value = str_replace(',', '.', $value);
        return (float) $value;
    }
}