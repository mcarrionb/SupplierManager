<?php

namespace App\Enum;

class SupplierCategoryEnum
{
    public const HOTEL = 'hotel';
    public const PISTA = 'pista';
    public const COMPLEMENTO = 'complemento';

    /**
     * Options for form field: 'Visible Label' => 'Value stored in DB'
     */
    public static function getChoices(): array
    {
        return [
            'Hotel' => self::HOTEL,
            'Pista' => self::PISTA,
            'Complemento' => self::COMPLEMENTO,
        ];
    }
}
