<?php

declare(strict_types=1);

namespace PayHero\Calculator\Input;

/**
 * Class Event.
 *
 * Data representation of one input line
 */
class Event
{
    private $data;

    /**
     * Event constructor.
     */
    public function __construct(array $line)
    {
        $this->parseData($line);
    }

    /**
     * Returns the data array for the event.
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Parses line data array to a key value internal array
     * and sets it as object property.
     */
    private function parseData(array $inputArray)
    {
        $data = [
            'date' => $inputArray[0],
            'personId' => $inputArray[1],
            'personType' => $inputArray[2],
            'operation' => $inputArray[3],
            'amount' => $inputArray[4],
            'currency' => $inputArray[5],
        ];
        $this->data = $data;
    }
}
