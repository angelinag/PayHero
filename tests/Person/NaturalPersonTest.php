<?php

declare(strict_types=1);

namespace PayHero\Calculator\Tests\Person;

use PHPUnit\Framework\TestCase;
use PayHero\Calculator\Person\NaturalPerson;

class NaturalPersonTest extends TestCase
{
    /**
     * @param string $id
     * @param string $expectation
     *
     * @dataProvider userIdProvider
     */
    public function testGetUserId(string $id, string $expectation)
    {
        $person = new NaturalPerson($id);
        $this->assertEquals($expectation, $person->getUserId());
    }

    /**
     * @param string $id
     * @param string $value
     * @param string $expectation
     *
     * @dataProvider userCashOutAmountProvider
     */
    public function getLastCashOutAmountTest(string $id, string $value, string $expectation)
    {
        $person = new NaturalPerson($id);
        $person->setLastCashOutAmount((float)$value);

        $this->assertEquals($expectation, $person->getLastCashOutAmount());
    }

    /**
     * @param string $id
     * @param string $value
     * @param string $expectation
     *
     * @dataProvider userCashOutAmountProvider
     */
    public function setLastCashOutAmountTest(string $id, string $value, string $expectation)
    {
        $this->getLastCashOutAmountTest($id, $value, $expectation);
    }

    public function userIdProvider(): array
    {
        return [
            ['3', '3'],
            ['5', '5'],
            ['12', '12'],
            ['0', '0'],
            ['-4', '-4'],
        ];
    }

    public function userCashOutAmountProvider(): array
    {
        return [
            ['3', '50', '50'],
            ['4', '50', '50'],
            ['4', '1000', '1000'],
            ['0', '-3000', '-3000'],
        ];
    }
}