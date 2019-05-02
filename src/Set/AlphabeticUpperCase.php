<?php

namespace App\Set;

use App\Generator\UpsideDownACSII;

/**
 * Set of uppercase alphabetic characters.
 * From "A" to "Z"
 */
class AlphabeticUpperCase implements Set
{
    use UpsideDownACSII;

    /**
     * @inheritdoc
     */
    public function getAvailableCharacters(): array
    {
        return $this->generateCharsFromUpsideDown(65, 90);
    }

    /**
     * @inheritdoc
     */
    public static function getDescription(): string
    {
        return 'Upper case characters of alphabet. From "A" to "Z"';
    }
}
