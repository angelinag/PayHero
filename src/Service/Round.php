<?php

declare(strict_types=1);

namespace PayHero\Calculator\Service;

/**
 * Class Round.
 *
 * Rounds up with respect to the currency type.
 */
class Round
{
    private $config;

    /**
     * Round constructor.
     *
     * @param object $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Performs rounding to nearest highest value.
     *
     * @param $value
     */
    public function round($value, string $currencyName): float
    {
        $scale = $this->config->currencies[$currencyName]['roundingScale'];
        $value = (float) $value;
        if ($scale === 0) { // for currencies without point something
            return ceil($value);
        } else {
            $pow = pow(10, $scale);

            return (ceil($pow * $value)
                    + ceil($pow * $value - ceil($pow * $value)))
                / $pow;
        }
    }
}
