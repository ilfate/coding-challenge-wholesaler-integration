<?php declare(strict_types=1);

namespace kollex\Config;

use kollex\Entity\WholesalerDataSource;

class DataConfig implements IConfig
{
    /**
     * @inheritDoc
     */
    public function getConfig(): array
    {
        return [
            new WholesalerDataSource(WholesalerDataSource::TYPE_CSV, __DIR__ . '/../../../data/wholesaler_a.csv'),
            new WholesalerDataSource(WholesalerDataSource::TYPE_JSON, __DIR__ . '/../../../data/wholesaler_b.json'),
        ];
    }
}