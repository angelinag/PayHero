<?php

declare(strict_types=1);

namespace PayHero\Calculator\Operation;

use PayHero\Calculator\Service\Convert;
use PayHero\Calculator\Service\Math;
use PayHero\Calculator\Service\Round;

/**
 * Class CashIn.
 *
 * Implements the business logic behind the cashing in operation.
 */
class CashIn implements OperationInterface
{
    private $value;
    private $currency;
    private $personId;
    private $personType;
    private $config;

    /**
     * CashIn constructor.
     *
     * @param object $config
     */
    public function __construct(array $properties, $config)
    {
        $this->value = $properties['amount'];
        $this->currency = $properties['currency'];
        $this->personId = $properties['personId'];
        $this->personType = $properties['personType'];
        $this->config = $config;
    }

    /**
     * Calculates the commission for cashing in operation.
     * In this scenario the commission is the same for all persons.
     *
     * @return float|int
     */
    public function getCommission()
    {
        $currency = $this->currency;
        $config = $this->config;
        $math = new Math($config);
        $conv = new Convert($config);
        $commission = $math->percentage($this->value, $config->cash_in_commission_fee_percentage);
        $commissionInEur = $conv->convertToEur($currency, $commission);
        if ($commissionInEur > $config->cash_in_commission_fee_max_EUR) {
            return 5;
        }
        $round = new Round($config);

        return $round->round($commission, $currency);
    }
}
