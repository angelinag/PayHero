<?php

declare(strict_types=1);

namespace PayHero\Calculator\Operation;

/**
 * Interface OperationInterface.
 *
 * Defines the methods for an operation
 */
interface OperationInterface
{
    public function __construct(array $properties, $config);

    public function getCommission();
}
