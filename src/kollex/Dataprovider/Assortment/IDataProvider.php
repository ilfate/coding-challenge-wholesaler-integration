<?php

namespace kollex\Dataprovider\Assortment;

use kollex\Entity\IProduct;
use kollex\Entity\WholesalerDataSource;

interface IDataProvider
{
    /**
     * @param WholesalerDataSource $dataSource
     * @return IProduct[]
     */
    public function getProducts(WholesalerDataSource $dataSource) : array;
}
