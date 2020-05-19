<?php

declare(strict_types=1);

namespace PayHero\Calculator\Input;

use PayHero\Calculator\Operation\OperationFactory;

/**
 * Class InputOutputHandler.
 *
 * Handles the input line and generates content for one output line
 */
class InputOutputHandler
{
    /**
     * Calculates the commission for the event and returns it adequately trimmed.
     *
     * @param object $config
     */
    public static function handle(Event $e, $config): string
    {
        $commission = self::calculateCommission($e, $config);

        return self::beautify($commission, $e, $config);
    }

    /**
     * Creates the necessary operation via factory and gets the commission from that instance.
     *
     * @param object $config
     *
     * @return mixed
     */
    public static function calculateCommission(Event $e, $config)
    {
        $data = $e->getData();
        $typeOfOperation = $data['operation'];
        $oper = OperationFactory::getOperationObject($typeOfOperation, $data, $config);

        return $oper->getCommission();
    }

    /**
     * Formats the output in accordance with the currency.
     *
     * @param object $config
     */
    public static function beautify(float $commission, Event $e, $config): string
    {
        $currency = $e->getData()['currency'];
        $scale = $config->currencies[$currency]['roundingScale'];
        $formatString = '%0.'.$scale.'f';

        return sprintf($formatString, $commission);
    }
}
