<?php

declare(strict_types=1);

namespace PayHero\Calculator\Service;

/**
 * Class Convert.
 *
 * Converts money from a currency to euro and vice versa.
 */
class Convert
{
    private $config;

    /**
     * Convert constructor.
     *
     * @param object $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Converts a value from a currency to euro.
     */
    public function convertToEur(string $currencyName, string $value): string
    {
        $rate = $this->config->currencies[$currencyName]['forOneEUR'];
        $m = new Math($this->config);

        return $m->divide((string) $value, (string) $rate);
    }

    /**
     * Converts a value from euro to another currency.
     */
    public function convertFromEur(string $currencyName, string $value): string
    {
        $rate = $this->config->currencies[$currencyName]['forOneEUR'];
        $m = new Math($this->config);

        return $m->multiply((string) $value, (string) $rate);
    }
}
