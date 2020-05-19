<?php

declare(strict_types=1);

namespace PayHero\Calculator\Tests\Service;

use PHPUnit\Framework\TestCase;
use PayHero\Calculator\Service\Round;

class RoundTest extends TestCase
{
    /**
     * @var Round
     */
    private $round;

    /**
     * @dataProvider configProvider
     */
    public function setUp()
    {
        $this->round = new Round($this->configProvider());
    }

    /**
     * @param string $currencyName
     * @param string $value
     * @param string $expectation
     *
     * @dataProvider roundProvider
     */
    public function testRound(string $currencyName, string $value, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->round->round($value, $currencyName)
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

    public function roundProvider(): array
    {
        return [
            ['JPY', '6', '6'],
            ['JPY', '12', '12'],
            ['JPY', '129.53', '130'],
            ['JPY', '129.5', '130'],
            ['JPY', '129.4', '130'],
            ['JPY', '129.1', '130'],
            ['JPY', '129.99999999', '130'],
            ['JPY', '130', '130'],
            ['USD', '5.545', '5.55'],
            ['USD', '5.541', '5.55'],
            ['USD', '5.549', '5.55'],
            ['USD', '5.550', '5.55'],
            ['EUR', '2.545', '2.55'],
            ['EUR', '2.541', '2.55'],
            ['EUR', '2.549', '2.55'],
            ['EUR', '2.550', '2.55'],
            ['EUR', '0', '0'],
        ];
    }
}
