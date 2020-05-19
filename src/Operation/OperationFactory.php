<?php

declare(strict_types=1);

namespace PayHero\Calculator\Operation;

use ReflectionClass;

/**
 * Class OperationFactory.
 *
 * Creates operation object instances
 */
class OperationFactory
{
    /**
     * Creates and returns an operation instance by a specified type.
     *
     * @param object $config
     *
     * @return object
     */
    public static function getOperationObject(string $unformattedName, array $data, $config)
    {
        $formatted = self::formatClassName($unformattedName);
        $classPath = self::getFullNamespacePath($formatted);
        $args = [$data, $config];
        $class = new ReflectionClass("$classPath");

        return $class->newInstanceArgs($args);
    }

    /**
     * Formats the class name from a lowercase string to a functioning name.
     */
    public static function formatClassName(string $unformattedName): string
    {
        $words = explode('_', $unformattedName);
        $newName = '';
        foreach ($words as $word) {
            $word = ucfirst($word);
            $newName = $newName.$word;
        }

        return $newName;
    }

    /**
     * Returns the namespace plus class name.
     */
    public static function getFullNamespacePath(string $name): string
    {
        return __NAMESPACE__.'\\'.$name;
    }
}
