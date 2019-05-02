<?php

namespace App\Generator;

use App\Set\Set;

class Generator
{
    /** @var Set[] */
    private $sets;

    /** @var integer */
    private $length;

    /** @var string[] */
    private $chars;

    public function __construct(array $sets, int $length)
    {
        if (empty($sets)) {
            throw new \LogicException('Generator must have at least one set');
        }

        foreach ($sets as $set) {
            if (!($set instanceof Set)) {
                throw new \LogicException(sprintf('The class "%s" don\'t implement the "%s" interface', get_class($set), Set::class));
            }
        }

        $this->sets = $sets;

        if ($length <= 0) {
            throw new \LogicException('Length must be positive');
        }

        $this->length = $length;
        $this->buildListOfChars();
    }

    public function generate(): string
    {
        $password = '';

        for ($i = 0; $i < $this->length; $i++) {
            $rChar = $this->chars[array_rand($this->chars)];
            $password .= $rChar;
        }

        return $password;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    private function buildListOfChars()
    {
        $chars = [];
        foreach ($this->sets as $set) {
            foreach ($set->getAvailableCharacters() as $char) {
                // The getAvailableCharacters method MUST return an array containing strings of ONE character
                if (!is_string($char) || 1 !== strlen($char)) {
                    continue;
                }

                $chars[] = $char;
            }
        }

        $chars = array_unique($chars);
        shuffle($chars);
        $this->chars = $chars;
    }
}
