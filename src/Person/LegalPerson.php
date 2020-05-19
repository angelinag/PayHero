<?php

declare(strict_types=1);

namespace PayHero\Calculator\Person;

/**
 * Class LegalPerson.
 *
 * Represents a legal person.
 * Extends class BasePerson
 */
class LegalPerson extends BasePerson
{
    /**
     * LegalPerson constructor, calls parent one.
     *
     * @param int $amount
     */
    public function __construct(string $id, $amount = 0)
    {
        parent::__construct($id, $amount);
    }
}
