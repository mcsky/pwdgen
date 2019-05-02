<?php

namespace App\Set;

class SpecialCharacters implements Set
{
    /**
     * @inheritdoc
     */
    public function getAvailableCharacters(): array
    {
        return [
            ';', ',', '%', '^', '-', '_', '!', '?',
            '$', '#', '.', '+', '=', '^', '*', '°'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getDescription(): string
    {
        return 'Return a set of specials characters';
    }
}
