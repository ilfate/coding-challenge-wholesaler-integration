<?php declare(strict_types=1);

namespace kollex\Dataprovider;

use DI\ContainerBuilder;
use kollex\Dataprovider\Assortment\CsvDataProvider;
use kollex\Dataprovider\Assortment\IDataProvider;
use kollex\Dataprovider\Assortment\JsonDataProvider;
use kollex\Dataprovider\Exception\UnimplementedDataTypeException;
use kollex\Entity\WholesalerDataSource;

class DataProviderBuilder
{
    /**
     * @var \DI\Container
     */
    private $container;

    public function __construct()
    {
        $this->container = (new ContainerBuilder())->addDefinitions(__DIR__ . '/../../../di.php')->build();
    }

    public function getDataProvider(string $type): IDataProvider
    {
        switch ($type) {
            case WholesalerDataSource::TYPE_JSON:
                return $this->container->get(JsonDataProvider::class);
            case WholesalerDataSource::TYPE_CSV:
                return $this->container->get(CsvDataProvider::class);
            default:
                throw new UnimplementedDataTypeException("Data type '$type' does not have a DataProvider implemented for it");
        }
    }
}