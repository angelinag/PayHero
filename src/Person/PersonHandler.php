<?php

declare(strict_types=1);

namespace PayHero\Calculator\Person;

/**
 * Class PersonHandler.
 *
 * Handles all functionality concerning the users.
 * Operates via GLOBALS where the user information is stored.
 */
class PersonHandler
{
    private $userId;
    private $user;

    /**
     * PersonHandler constructor.
     */
    public function __construct(string $userId, string $userType)
    {
        $this->userId = $userId;
        if (!$this->isSetUser($userId)) {
            $this->createUser($userId, $userType);
        }
        $this->user = $this->getUser($userId);
    }

    /**
     * Checks if user exists.
     */
    public function isSetUser(string $userId): bool
    {
        foreach ($GLOBALS['users'] as $u) {
            if ($u->getUserId() === $userId) {
                return true;
            }
        }

        return false;
    }

    /**
     * Creates and returns a new user instance with respect to the type.
     */
    public function getNewUserByType(string $id, string $userType): BasePerson
    {
        if ($userType === 'natural') {
            return new NaturalPerson($id);
        } else {
            return new LegalPerson($id);
        }
    }

    /**
     * Creates a new user.
     */
    public function createUser(string $userId, string $userType)
    {
        if (!$this->isSetUser($userId)) {
            array_push($GLOBALS['users'], $this->getNewUserByType($userId, $userType));
        }
        $this->setDefaultTransactionAmount();
    }

    /**
     * Returns a person if they exist or null.
     *
     * @return BasePerson|null
     */
    public function getUser(string $userId)
    {
        foreach ($GLOBALS['users'] as $u) {
            if ($u->getUserId() === $userId) {
                return $u;
            }
        }

        return null;
    }

    /**
     * Returns the number of transactions the person has made the current week.
     */
    public function getUserTransactionNumber(): int
    {
        return $GLOBALS['numberOfTransactions'][$this->userId];
    }

    /**
     * Increases the number of transations the person has made the current week
     * by 1.
     *
     * @return void
     */
    public function increaseUserTransactionNumber()
    {
        ++$GLOBALS['numberOfTransactions'][$this->userId];
    }

    /**
     * Sets the number of transactions the person has made the current week to 0.
     *
     * @return void
     */
    public static function resetUserTransactionNumber()
    {
        foreach ($GLOBALS['numberOfTransactions'] as $index => $n) {
            $GLOBALS['numberOfTransactions'][$index] = 0;
        }
    }

    /**
     * Sets the default transaction amount 0 of the user.
     *
     * @return void
     */
    public function setDefaultTransactionAmount()
    {
        $GLOBALS['numberOfTransactions']["$this->userId"] = 0;
    }

    /**
     * Returns the current transaction amount for the user for the current week.
     *
     * @return float|int
     */
    public function getUserTransactionAmount()
    {
        return $this->user->getLastCashOutAmount();
    }

    /**
     * Adds a value to the current transaction amount for the week.
     *
     * @return void
     */
    public function addToUserTransactionAmount(float $value)
    {
        $currentAmount = $this->getUserTransactionAmount();
        $newAmount = $currentAmount + $value;
        $this->user->setLastCashOutAmount($newAmount);
    }

    /**
     * Sets all transaction amounts for the current week
     * to 0 for all users.
     *
     * @return void
     */
    public static function resetTransactionAmounts()
    {
        foreach ($GLOBALS['users'] as $u) {
            $u->setLastCashOutAmount(0);
        }
    }
}
