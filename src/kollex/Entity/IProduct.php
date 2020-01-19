<?php


namespace kollex\Entity;


use kollex\Entity\ProductField\BaseProductPackaging;
use kollex\Entity\ProductField\BaseProductUnit;
use kollex\Entity\ProductField\Packaging;

interface IProduct extends \JsonSerializable
{
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
    );
}
