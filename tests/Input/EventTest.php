<?php

declare(strict_types=1);

namespace PayHero\Calculator\Tests\Input;

use PHPUnit\Framework\TestCase;
use PayHero\Calculator\Input\Event;

class EventTest extends TestCase
{
    /**
     * @param array $line
     * @param array $expectation
     *
     * @dataProvider getDataProvider
     */
    public function testGetData(array $line, array $expectation)
    {
        $e = new Event($line);
        $this->assertEquals($expectation, $e->getData());
    }

    public function getDataProvider(): array
    {
        return [
            [
                ['2014-12-31', '4', 'natural', 'cash_out', '1200.00', 'EUR'],
                [
                    "date" => '2014-12-31',
                    "personId" => '4',
                    "personType" => 'natural',
                    "operation" => 'cash_out',
                    "amount" => '1200.00',
                    "currency" => 'EUR'
                ]
            ],
            [
                ['2016-01-06', '1', 'natural', 'cash_out', '30000', 'JPY'],
                [
                    "date" => '2016-01-06',
                    "personId" => '1',
                    "personType" => 'natural',
                    "operation" => 'cash_out',
                    "amount" => '30000',
                    "currency" => 'JPY'
                ]
            ],
            [
                ['0', '0', '0', '0', '0', '0'],
                [
                    "date" => '0',
                    "personId" => '0',
                    "personType" => '0',
                    "operation" => '0',
                    "amount" => '0',
                    "currency" => '0'
                ]
            ],
            [
                [null, null, null, null, null, null],
                [
                    "date" => null,
                    "personId" => null,
                    "personType" => null,
                    "operation" => null,
                    "amount" => null,
                    "currency" => null                ]
            ],
        ];
    }
}