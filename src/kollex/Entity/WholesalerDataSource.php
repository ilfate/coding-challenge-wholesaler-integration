<?php
declare(strict_types=1);


namespace kollex\Config\Entity;


class WholesalerDataSource
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $fileName;

    public function __construct(string $type, string $fileName)
    {

        $this->type = $type;
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

}