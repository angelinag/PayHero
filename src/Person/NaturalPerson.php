<?php

declare(strict_types=1);

namespace PayHero\Calculator\Person;

/**
 * Class NaturalPerson.
 *
 * Represents a natural person.
 * Extends class BasePerson
 */
class NaturalPerson extends BasePerson
{
    /**
     * NaturalPerson constructor, calls parent one.
     *
     * @param int $amount
     */
    public function __construct(string $id, $amount = 0)
    {
        parent::__construct($id, $amount);
    }
}
