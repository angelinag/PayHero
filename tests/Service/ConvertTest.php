<?php

declare(strict_types=1);

namespace PayHero\Calculator\Tests\Service;

use PHPUnit\Framework\TestCase;
use PayHero\Calculator\Service\Convert;

class ConvertTest extends TestCase
{
    /**
     * @var Convert
     */
    private $convert;

    /**
     * @dataProvider configProvider
     */
    public function setUp()
    {
        $this->convert = new Convert($this->configProvider());
    }

    /**
     * @param string $currencyName
     * @param string $value
     * @param string $expectation
     *
     * @dataProvider toEurProvider
     */
    public function testConvertToEur(string $currencyName, string $value, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->convert->convertToEur($currencyName, $value)
        );
    }

    /**
     * @param string $currencyName
     * @param string $value
     * @param string $expectation
     *
     * @dataProvider fromEurProvider
     */
    public function testConvertFromEur(string $currencyName, string $value, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->convert->convertFromEur($currencyName, $value)
        );
    }

    public function configProvider()
    {
        return (object) [
            'maxScale' => 10,
            'currencies' => array(
                'EUR' => array(
                    'roundingScale' => 2,
                    'forOneEUR' => 1
                ),
                'USD' => array(
                    'roundingScale' => 2,
                    'forOneEUR' => 1.1497
                ),
                'JPY' => array(
                    'roundingScale' => 0,
                    'forOneEUR' => 129.53
                )
            )
        ];
    }

    public function toEurProvider(): array
    {
        return [
            ['JPY', '129.53', '1'],
            ['JPY', '3', '0.0231606577'],
            ['USD', '1.1497', '1'],
            ['USD', '5', '4.3489605984'],
        ];
    }

    public function fromEurProvider(): array
    {
        return [
            ['JPY', '1', '129.53'],
            ['JPY', '5', '647.65'],
            ['USD', '1', '1.1497'],
            ['USD', '3.25', '3.736525'],
        ];
    }
}
