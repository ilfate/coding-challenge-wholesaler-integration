<?php declare(strict_types=1);

namespace kollex\Config;

use kollex\Entity\WholesalerDataSource;

interface IConfig
{
    /**
     * @return WholesalerDataSource[]
     */
    public function getConfig(): array;
}