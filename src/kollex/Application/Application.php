<?php declare(strict_types=1);

namespace kollex\Application;

use kollex\Config\IConfig;
use kollex\Dataprovider\DataProviderBuilder;

/**
 * The goal of this application is to read files of different type and return all data in one format
 *
 * Class Application
 * @package kollex\Application
 */
class Application
{
    /**
     * @var \kollex\Entity\WholesalerDataSource[]
     */
    private $sources;
    /**
     * @var DataProviderBuilder
     */
    private $dataProviderBuilder;

    public function __construct(IConfig $config, DataProviderBuilder $dataProviderBuilder)
    {
        $this->sources = $config->getConfig();
        $this->dataProviderBuilder = $dataProviderBuilder;
    }

    public function run() {
        $products = [];
        foreach ($this->sources as $source) {
            $dataProvider = $this->dataProviderBuilder->getDataProvider($source->getType());
            $products = array_merge($products, $dataProvider->getProducts($source));
        }
        echo json_encode(['payload' => $products]);
    }
}