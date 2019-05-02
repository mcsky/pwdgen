<?php

namespace App\Set;

use App\Generator\GeneratorException;
use Symfony\Component\Console\Exception\InvalidOptionException;

final class Sets
{
    const ALPHABETIC_LOWERCASE = 1;
    const ALPHABETIC_UPPERCASE = 2;
    const NUMERIC              = 4;
    const SPECIAL              = 8;

    const SETS_BY_BIT = [
        self::ALPHABETIC_LOWERCASE => AlphabeticLowerCase::class,
        self::ALPHABETIC_UPPERCASE => AlphabeticUpperCase::class,
        self::NUMERIC              => Numeric::class,
        self::SPECIAL              => SpecialCharacters::class,
    ];

    /**
     * @param int $askedBitMask A bitmask representing user's sets needs to generate password
     * @return Set[]
     * @throws GeneratorException
     */
    public static function getSets(int $askedBitMask): array
    {
        $maxBitmask = array_sum(array_keys(self::SETS_BY_BIT));
        if ($askedBitMask > $maxBitmask) {
            throw new InvalidOptionException(sprintf('Specified bitmask is "%s", but the max bitmask value is "%d"', $askedBitMask, $maxBitmask));
        }

        $sets = [];
        foreach (self::SETS_BY_BIT as $bitMask => $className) {
            if (!($askedBitMask & $bitMask)) {
                continue;
            }

            // We found a set matching the user's bitmask requirements
            $set = new $className();
            if (!($set instanceof Set)) {
                throw new \RuntimeException('This object don\'t implement Set interface !');
            }

            $sets[] = $set;
        }

        return $sets;
    }

    public static function getDescription($bitValue): string
    {
        if (!isset(self::SETS_BY_BIT[$bitValue])) {
            throw new GeneratorException(sprintf('No set for bit mask "%d"', $bitValue));
        }

        $setClass = self::SETS_BY_BIT[$bitValue];
        $getDescriptionFunction = sprintf('%s::getDescription', $setClass);
        if ((!method_exists($setClass, 'getDescription') || !is_callable($getDescriptionFunction))) {
            return '';
        }

        return call_user_func($getDescriptionFunction);
    }

    public static function getSetsDescription(): string
    {
        $description = '';
        foreach (self::SETS_BY_BIT as $bitmask => $setClass) {
            $description .= sprintf('    "%d" - %s  // %s', $bitmask, $setClass, self::getDescription($bitmask)) . PHP_EOL;
        }

        return $description;
    }
}
