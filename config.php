<?php

return (object) array(
    'maxScale' => 10,
    'cash_in_commission_fee_percentage' => '0.03',
    'cash_in_commission_fee_max_EUR' => 5,
    'cash_out_natural_person_commission_fee_percentage' => '0.3',
    'cash_out_legal_person_commission_fee_percentage' => '0.3',
    'cash_out_legal_person_commission_fee_min_EUR' => '0.50',
    'currencies' => array(
        'EUR' => array(
            'roundingScale' => 2,
            'forOneEUR' => 1
        ),
        'USD' => array(
            'roundingScale' => 2,
            'forOneEUR' => 1.1497
        ),
        'JPY' => array(
            'roundingScale' => 0,
            'forOneEUR' => 129.53
        )
    )
);

