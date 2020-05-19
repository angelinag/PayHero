<?php

declare(strict_types=1);

namespace PayHero\Calculator\Person;

/**
 * Class BasePerson.
 *
 * A base class for natural and legal person classes.
 */
abstract class BasePerson
{
    protected $userId;
    protected $lastCashOutAmount;

    /**
     * BasePerson constructor.
     *
     * @param float|int $amount
     */
    public function __construct(string $id, $amount = 0)
    {
        $this->userId = $id;
        $this->lastCashOutAmount = $amount;
    }

    /**
     * Returns user id.
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * Returns last recorded cash out amount for the user.
     *
     * @return float|int
     */
    public function getLastCashOutAmount()
    {
        return $this->lastCashOutAmount;
    }

    /**
     * Sets last recorded cash out amount for the user.
     */
    public function setLastCashOutAmount(float $amount)
    {
        $this->lastCashOutAmount = $amount;
    }
}
