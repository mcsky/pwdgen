<?php

namespace App\Set;

use App\Generator\UpsideDownACSII;

/**
 * Set of lowercase alphabetic characters.
 * From "a" to "z"
 */
class AlphabeticLowerCase implements Set
{
    use UpsideDownACSII;

    /**
     * @inheritdoc
     */
    public function getAvailableCharacters(): array
    {
        return $this->generateCharsFromUpsideDown(97, 122);
    }

    /**
     * @inheritdoc
     */
    public static function getDescription(): string
    {
        return 'Lower case characters of alphabet. From "a" to "z"';
    }
}
