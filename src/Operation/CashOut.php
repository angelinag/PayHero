<?php

declare(strict_types=1);

namespace PayHero\Calculator\Operation;

use PayHero\Calculator\Person\PersonHandler;
use PayHero\Calculator\Service\Convert;
use PayHero\Calculator\Service\Math;
use PayHero\Calculator\Service\Round;

/**
 * Class CashOut.
 *
 * Implements the business logic behind the cashing out operation.
 */
class CashOut implements OperationInterface
{
    private $value;
    private $currency;
    private $personId;
    private $personType;
    private $config;

    /**
     * CashOut constructor.
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
     * Calculates commission for cash out in accordance with person type.
     *
     * @return float|int
     */
    public function getCommission()
    {
        $currency = $this->currency;
        $personId = $this->personId;
        $personType = $this->personType;
        $config = $this->config;
        if ($personType === 'legal') {
            return $this->getCommissionLegal($currency, $config);
        } elseif ($personType === 'natural') {
            return $this->getCommissionNatural($personId, $currency, $config);
        }

        return 0;
    }

    /**
     * Calculates the commission for a natural person.
     *
     * @param object $config
     *
     * @return float|int
     */
    public function getCommissionNatural(string $personId, string $currency, $config)
    {
        $value = $this->value;
        $personHandler = new PersonHandler($personId, 'natural');

        $conv = new Convert($config);
        $round = new Round($config);

        $currentAmount = $personHandler->getUserTransactionAmount();
        $valueInEur = $round->round($conv->convertToEur($currency, $value), $currency);
        $personHandler->addToUserTransactionAmount($valueInEur);

        $numberOfTransactionsThisWeek = $personHandler->getUserTransactionNumber();
        $personHandler->increaseUserTransactionNumber();

        if ($numberOfTransactionsThisWeek < 3 & $currentAmount < 1000) {
            $allowedFreeAmountLeft = 1000 - $currentAmount;
            if ($valueInEur <= $allowedFreeAmountLeft) {
                return 0;
            } else {
                $valueInEur = $valueInEur - $allowedFreeAmountLeft;
                $value = $conv->convertFromEur($currency, (string) $valueInEur);
            }
        }

        $math = new Math($config);
        $commission = $math->percentage($value, $config->cash_out_natural_person_commission_fee_percentage);

        return $round->round($commission, $currency);
    }

    /**
     * Calculates the commission for a legal person.
     *
     * @param object $config
     *
     * @return float
     */
    public function getCommissionLegal(string $currency, $config)
    {
        $value = $this->value;
        $math = new Math($config);
        $conv = new Convert($config);
        $commission = $math->percentage($value, $config->cash_out_legal_person_commission_fee_percentage);
        $commissionInEur = $conv->convertToEur($currency, $commission);
        if ($commissionInEur < $config->cash_out_legal_person_commission_fee_min_EUR) {
            return $config->cash_out_legal_person_commission_fee_min_EUR;
        }
        $round = new Round($config);

        return $round->round($commission, $currency);
    }
}
