<?php


namespace kollex\Entity;


interface IProduct
{
    public function getId();
    public function getGtin();
    public function getManufacturer();
    public function getName();
    public function getPackaging();
    public function getBaseProductPackaging();
    public function getBaseProductUnit();
    public function getBaseProductAmount();
    public function getBaseProductQuantity();
}
