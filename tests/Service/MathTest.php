<?php

declare(strict_types=1);

namespace PayHero\Calculator\Tests\Service;

use PHPUnit\Framework\TestCase;
use PayHero\Calculator\Service\Math;

class MathTest extends TestCase
{
    /**
     * @var Math
     */
    private $math;

    /**
     * @dataProvider configProvider
     */
    public function setUp()
    {
        $this->math = new Math($this->configProvider());
    }

    /**
     * @param string $leftOperand
     * @param string $rightOperand
     * @param string $expectation
     *
     * @dataProvider additionProvider
     */
    public function testAdd(string $leftOperand, string $rightOperand, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->math->add($leftOperand, $rightOperand)
        );
    }

    /**
     * @param string $leftOperand
     * @param string $rightOperand
     * @param string $expectation
     *
     * @dataProvider subtractionProvider
     */
    public function testSubtract(string $leftOperand, string $rightOperand, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->math->subtract($leftOperand, $rightOperand)
        );
    }

    /**
     * @param string $leftOperand
     * @param string $rightOperand
     * @param string $expectation
     *
     * @dataProvider multiplicationProvider
     */
    public function testMultiply(string $leftOperand, string $rightOperand, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->math->multiply($leftOperand, $rightOperand)
        );
    }

    /**
     * @param string $leftOperand
     * @param string $rightOperand
     * @param string $expectation
     *
     * @dataProvider divisionProvider
     */
    public function testDivide(string $leftOperand, string $rightOperand, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->math->divide($leftOperand, $rightOperand)
        );
    }

    /**
     * @param string $leftOperand
     * @param string $rightOperand
     * @param string $expectation
     *
     * @dataProvider divisionByZeroProvider
     */
    public function testDivideByZero(string $leftOperand, string $rightOperand, string $expectation)
    {
        $this->expectException(\Exception::class);
        $this->assertEquals(
            $expectation,
            $this->math->divide($leftOperand, $rightOperand)
        );
    }

    /**
     * @param string $operand
     * @param string $percentage
     * @param string $expectation
     *
     * @dataProvider percentageProvider
     */
    public function testPercentage(string $operand, string $percentage, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->math->percentage($operand, $percentage)
        );
    }

    public function configProvider()
    {
        return (object) [
            'maxScale' => 10
        ];
    }

    public function additionProvider(): array
    {
        return [
            'add 2 natural numbers' => ['1', '2', '3'],
            'add negative number to a positive' => ['-1', '2', '1'],
            'add natural number to a float' => ['1', '1.05123', '2.05123'],
        ];
    }

    public function subtractionProvider(): array
    {
        return [
            'subtract 2 natural numbers' => ['3', '2', '1'],
            'subtract a positive number from a negative one' => ['-1', '2', '-3'],
            'subtract natural number from a float' => ['2.0918', '1', '1.0918'],
            'subtract float from a natural number' => ['1', '0.333333', '0.666667'],
        ];
    }

    public function multiplicationProvider(): array
    {
        return [
            'multiply a natural number with another natural one' => ['3', '4', '12'],
            'multiply a natural number with a float' => ['2', '3.04', '6.08'],
            'multiply a float with another float' => ['5.36', '0.71', '3.8056'],
            'multiply a natural number with 0' => ['3', '0', '0'],
            'multiply a float with 0' => ['4.918', '0', '0'],
        ];
    }

    public function divisionProvider(): array
    {
        return [
            'divide a natural number by another natural one' => ['15', '3', '5'],
            'divide a float by a natural number' => ['6.08', '2', '3.04'],
            'divide a natural number by a float' => ['3', '1.5', '2'],
            'divide a float by another float' => ['4.125', '1.25', '3.3'],
        ];
    }

    public function divisionByZeroProvider(): array
    {
        return [
            'divide a natural number by 0' => ['3', '0', '0'],
            'divide a float by 0' => ['4.918', '0', '0'],
        ];
    }

    public function percentageProvider(): array
    {
        return [
            'percentage of a natural number' => ['30', '50', '15'],
            'float percentage of a natural number' => ['78.4', '9', '7.056'],
            'percentage is a float, operand is natural' => ['50', '2.467', '1.2335'],
            'float percentage of a float operand' => ['4.91', '60.8', '2.98528'],
            'zero percentage of a number' => ['93.2', '0', '0'],
            'percentage of a zero number' => ['0', '62.3', '0'],
        ];
    }
}
