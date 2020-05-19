<?php

declare(strict_types=1);

namespace PayHero\Calculator\Tests\Service;

use PHPUnit\Framework\TestCase;
use PayHero\Calculator\Service\WeekManager;

class WeekManagerTest extends TestCase
{
    /**
     * @var WeekManager
     */
    private $manager;

    public function setUp()
    {
        $this->manager = new WeekManager();
    }

    /**
     * @param string $dateStringOne
     * @param string $dateStringTwo
     * @param bool $expectation
     *
     * @dataProvider weekStringsProvider
     */
    public function testCheckIsSameWeek(string $dateStringOne, string $dateStringTwo, bool $expectation)
    {
        $this->assertSame(
            $expectation,
            $this->manager::checkIsSameWeek($dateStringOne, $dateStringTwo)
        );
    }

    public function weekStringsProvider(): array
    {
        return [
            ['2017-12-30', '2018-01-01', false],
            ['2018-01-01', '2018-01-02', true],
            ['2019-12-30', '2020-01-01', true],
        ];
    }
}
