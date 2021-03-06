<?php declare(strict_types=1);

namespace kollex\Dataprovider\Assortment;

use kollex\Dataprovider\Exception\ErrorParsingFileException;
use kollex\Entity\IProduct;
use PHPUnit\Framework\TestCase;

class JsonDataProviderTest extends TestCase
{

    /**
     * @var JsonDataProvider
     */
    private $jsonDataProvider;
    /**
     * @var \ReflectionMethod
     */
    private $method;

    public function setUp()
    {
        parent::setUp();
        $this->jsonDataProvider = new JsonDataProvider();
        $this->method = new \ReflectionMethod(JsonDataProvider::class, 'parseFileIntoProducts');
        $this->method->setAccessible(true);
    }

    public function getWholeselerData()
    {
        return [
            [
                [
                    'data' => [[
                        "PRODUCT_IDENTIFIER" => "12345600003",
                        "EAN_CODE_GTIN" => "05449000000003",
                        "BRAND" => "Drinks Corp.",
                        "NAME" => "Beer, 6x 0.5L",
                        "PACKAGE" => "box",
                        "ADDITIONAL_INFO" => "lorem ips",
                        "VESSEL" => "can",
                        "LITERS_PER_BOTTLE" => "0,5",
                        "BOTTLE_AMOUNT" => "6"
                    ]]
                ], [
                    [
                        "id" => "12345600003",
                        "gtin" => "05449000000003",
                        "manufacturer" => "Drinks Corp.",
                        "name" => "Beer, 6x 0.5L",
                        "packaging" => "BX",
                        "baseProductPackaging" => "CN",
                        "baseProductUnit" => 'LT',
                        "baseProductAmount" => 0.5,
                        "baseProductQuantity" => 6
                    ]
                ]
            ],
            [
                [
                    'data' => [[
                        "PRODUCT_IDENTIFIER" => "12345600003",
                        "EAN_CODE_GTIN" => "05449000000003",
                        "BRAND" => "Drinks Corp.",
                        "NAME" => "Beer, 6x 0.5L",
                        "PACKAGE" => "BOTTLE",
                        "ADDITIONAL_INFO" => "lorem ips",
                        "VESSEL" => "bottle",
                        "LITERS_PER_BOTTLE" => "0,5",
                        "BOTTLE_AMOUNT" => "6"
                    ],[
                        "PRODUCT_IDENTIFIER" => "ASD123",
                        "EAN_CODE_GTIN" => "DDDEERRR123",
                        "BRAND" => "Drinks Corp.",
                        "NAME" => "Beer, 6x 0.5L",
                        "PACKAGE" => "box",
                        "ADDITIONAL_INFO" => "lorem ips",
                        "VESSEL" => "can",
                        "LITERS_PER_BOTTLE" => "4",
                        "BOTTLE_AMOUNT" => "6a"
                    ]]
                ], [
                    [
                        "id" => "12345600003",
                        "gtin" => "05449000000003",
                        "manufacturer" => "Drinks Corp.",
                        "name" => "Beer, 6x 0.5L",
                        "packaging" => "BO",
                        "baseProductPackaging" => "BO",
                        "baseProductUnit" => 'LT',
                        "baseProductAmount" => 0.5,
                        "baseProductQuantity" => 6
                    ],[
                        "id" => "ASD123",
                        "gtin" => "DDDEERRR123",
                        "manufacturer" => "Drinks Corp.",
                        "name" => "Beer, 6x 0.5L",
                        "packaging" => "BX",
                        "baseProductPackaging" => "CN",
                        "baseProductUnit" => 'LT',
                        "baseProductAmount" => 4,
                        "baseProductQuantity" => 6
                    ]
                ]
            ]
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
        $result = $this->method->invoke($this->jsonDataProvider, json_encode($wholeselerData));
        $this->assertTrue(is_array($result));
        $this->assertCount(count($wholeselerData['data']), $result);
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
     * @dataProvider getWholeselerData
     * @param $wholeselerData
     *
     * @throws \ReflectionException
     */
    public function testWrongPackaging($wholeselerData)
    {
        $this->expectException(ErrorParsingFileException::class);

        $wholeselerData['data'][0]['PACKAGE'] = 'WrongPacage';
        $result = $this->method->invoke($this->jsonDataProvider, json_encode($wholeselerData));
    }

    /**
     * @dataProvider getWholeselerData
     * @param $wholeselerData
     *
     * @throws \ReflectionException
     */
    public function testWrongBaseProductPackaging($wholeselerData)
    {
        $this->expectException(ErrorParsingFileException::class);

        $wholeselerData['data'][0]['VESSEL'] = 'WrongPacage';
        $result = $this->method->invoke($this->jsonDataProvider, json_encode($wholeselerData));
    }
}