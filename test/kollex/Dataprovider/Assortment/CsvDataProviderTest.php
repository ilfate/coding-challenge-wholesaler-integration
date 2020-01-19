<?php declare(strict_types=1);

namespace kollex\Dataprovider\Assortment;

use kollex\Dataprovider\Exception\ErrorParsingFileException;
use kollex\Entity\IProduct;
use PHPUnit\Framework\TestCase;

class CsvDataProviderTest extends TestCase
{

    /**
     * @var CsvDataProvider
     */
    private $csvDataProvider;
    /**
     * @var \ReflectionMethod
     */
    private $method;

    public function setUp()
    {
        parent::setUp();
        $this->csvDataProvider = new CsvDataProvider();
        $this->method = new \ReflectionMethod(CsvDataProvider::class, 'parseFileIntoProducts');
        $this->method->setAccessible(true);
    }

    public function getWholeselerData()
    {
        return [
            [

                "id;ean;manufacturer;product;description;packaging product;foo;packaging unit;amount per unit;stock;warehouse
12345600001;5449000000001;Drinks Corp.;Soda Drink, 12 * 1,0l;Lorem ipsum usu amet dicat nullam ea;case 12;bar;bottle;1.0l;123;north"
                , [
                    [
                        "id" => "12345600001",
                        "gtin" => "5449000000001",
                        "manufacturer" => "Drinks Corp.",
                        "name" => "Soda Drink, 12 * 1,0l",
                        "packaging" => "CA",
                        "baseProductPackaging" => "BO",
                        "baseProductUnit" => 'LT',
                        "baseProductAmount" => 1,
                        "baseProductQuantity" => 12
                    ]
                ]
            ],
        ];
    }

    /**
     * @dataProvider getWholeselerData
     * @param $wholeselerData
     * @param $expected
     * @throws \ReflectionException
     */
    public function testSimpleHappyCase($wholeselerData, $expected)
    {
        $result = $this->method->invoke($this->csvDataProvider, $wholeselerData);
        $this->assertTrue(is_array($result));
        $this->assertCount(count(explode("\n", $wholeselerData)) - 1, $result);
        foreach ($result as $num => $item) {
            $this->assertInstanceOf(IProduct::class, $item);
            $itemAsArray = json_decode(json_encode($item), true);
            foreach ($expected[$num] as $field => $value) {
                $this->assertArrayHasKey($field, $itemAsArray);
                $this->assertSame($value, $itemAsArray[$field]);
            }
        }
    }

    /**
     * @throws \ReflectionException
     */
    public function testWrongPackaging()
    {
        $this->expectException(ErrorParsingFileException::class);

        $this->method->invoke($this->csvDataProvider, "id;ean;manufacturer;product;description;packaging product;foo;packaging unit;amount per unit;stock;warehouse
12345600001;5449000000001;Drinks Corp.;Soda Drink, 12 * 1,0l;Lorem ipsum usu amet dicat nullam ea;WRONGcase 12;bar;bottle;1.0l;123;north");
    }

    /**
     * @throws \ReflectionException
     */
    public function testWrongBaseProductPackaging()
    {
        $this->expectException(ErrorParsingFileException::class);

        $this->method->invoke($this->csvDataProvider, "id;ean;manufacturer;product;description;packaging product;foo;packaging unit;amount per unit;stock;warehouse
12345600001;5449000000001;Drinks Corp.;Soda Drink, 12 * 1,0l;Lorem ipsum usu amet dicat nullam ea;case 12;bar;WRONG;1.0l;123;north");
    }
}