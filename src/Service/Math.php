<?php

declare(strict_types=1);

namespace PayHero\Calculator\Service;

/**
 * Class Math.
 *
 * Does all the mathematical operations included.
 */
class Math
{
    private $config;
    private $maxScale;

    /**
     * Math constructor.
     *
     * @param object $config
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->maxScale = $config->maxScale;
    }

    /**
     * Does the addition of two operands.
     */
    public function add(string $leftOperand, string $rightOperand): string
    {
        return bcadd($leftOperand, $rightOperand, $this->maxScale);
    }

    /**
     * Subtracts two operands.
     */
    public function subtract(string $leftOperand, string $rightOperand): string
    {
        return bcsub($leftOperand, $rightOperand, $this->maxScale);
    }

    /**
     * Multiplies two operands.
     */
    public function multiply(string $leftOperand, string $rightOperand): string
    {
        return bcmul($leftOperand, $rightOperand, $this->maxScale);
    }

    /**
     * Performs division on two operands.
     */
    public function divide(string $leftOperand, string $rightOperand): string
    {
        if ($rightOperand === '0') {
            throw new \Exception();
        }

        return bcdiv($leftOperand, $rightOperand, $this->maxScale);
    }

    /**
     * Returns the given percentage of operand.
     */
    public function percentage(string $operand, string $percentage): string
    {
        return $this->divide($this->multiply($operand, $percentage), '100');
    }
}
