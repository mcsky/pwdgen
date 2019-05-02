<?php

namespace App\Set;

interface Set
{
    /**
     * Return an array containing string of ONE character
     * Theses characters represent the set
     * @return string[]
     */
    public function getAvailableCharacters(): array;

    /**
     * A string to describe the purpose of your set
     * @return string
     */
    public static function getDescription(): string;
}
