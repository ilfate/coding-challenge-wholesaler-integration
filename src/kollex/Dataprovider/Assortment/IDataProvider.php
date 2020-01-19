<?php


namespace kollex\Dataprovider\Assortment;


interface DataProvider
{
    /**
     * @return Product[]
     */
    public function getProducts() : array;
}
