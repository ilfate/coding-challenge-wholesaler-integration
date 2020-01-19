<?php

namespace kollex\Entity;

use kollex\Entity\ProductField\BaseProductPackaging;
use kollex\Entity\ProductField\BaseProductUnit;
use kollex\Entity\ProductField\Packaging;

class Product implements IProduct
{
    private $id;
    private $gtin;
    private $manufacturer;
    private $name;
    /** @var Packaging  */
    private $packaging;
    /** @var BaseProductPackaging  */
    private $baseProductPackaging;
    /** @var BaseProductUnit  */
    private $baseProductUnit;
    private $baseProductAmount;
    private $baseProductQuantity;

    public function __construct(
        string $id,
        string $manufacturer,
        string $name,
        Packaging $packaging,
        BaseProductPackaging $baseProductPackaging,
        BaseProductUnit $baseProductUnit,
        float $baseProductAmount,
        int $baseProductQuantity,
        string $gtin = null
    ) {
        $this->id = $id;
        $this->manufacturer = $manufacturer;
        $this->name = $name;
        $this->packaging = $packaging;
        $this->baseProductPackaging = $baseProductPackaging;
        $this->baseProductUnit = $baseProductUnit;
        $this->baseProductAmount = $baseProductAmount;
        $this->baseProductQuantity = $baseProductQuantity;
        $this->gtin = $gtin;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'gtin' => $this->gtin,
            'manufacturer' => $this->manufacturer,
            'name' => $this->name,
            'packaging' => $this->packaging,
            'baseProductPackaging' => $this->baseProductPackaging,
            'baseProductUnit' => $this->baseProductUnit,
            'baseProductAmount' => $this->baseProductAmount,
            'baseProductQuantity' => $this->baseProductQuantity,
        ];
    }
}
