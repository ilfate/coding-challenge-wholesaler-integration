<?php declare(strict_types=1);

namespace kollex\Dataprovider\Assortment;

use kollex\Dataprovider\Exception\FileNotFoundException;
use kollex\Entity\WholesalerDataSource;

abstract class AbstractFileDataProvider implements IDataProvider
{

    /**
     * @inheritDoc
     * @throws FileNotFoundException
     */
    public function getProducts(WholesalerDataSource $dataSource) : array
    {
        if (!file_exists($dataSource->getFileName())) {
            throw new FileNotFoundException("File {$dataSource->getFileName()} was not found");
        }
        $fileContent = file_get_contents($dataSource->getFileName());
        return $this->parseFileIntoProducts($fileContent);
    }

    abstract protected function parseFileIntoProducts(string $fileContent);
}