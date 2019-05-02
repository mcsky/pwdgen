<?php

namespace App\Set;

use App\Generator\UpsideDownACSII;

/**
 * Set of numeric characters.
 * From "1" to "9"
 */
class Numeric implements Set
{
    use UpsideDownACSII;

    /**
     * @inheritdoc
     */
    public function getAvailableCharacters(): array
    {
        return $this->generateCharsFromUpsideDown(48, 57);
    }

    /**
     * @inheritdoc
     */
    public static function getDescription(): string
    {
        return 'Set of number from 0 to 9.';
    }
}
