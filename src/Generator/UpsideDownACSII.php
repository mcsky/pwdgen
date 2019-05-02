<?php

namespace App\Generator;

trait UpsideDownACSII
{
    /**
     * @param int $min
     * @param int $max
     * @return array
     */
    public function generateCharsFromUpsideDown(int $min, int $max): array
    {
        if ($min >= $max) {
            throw new GeneratorException('Min should be less than max !');
        }

        if ($max > 127) { // Last character of ACSII table
            throw new \LogicException('Last character of ACSII table is 127, you provided ' . $max . ' at ' . __FUNCTION__ . ' function !');
        }

        $chars = [];
        for (; $min <= $max; $min++) {
            $chars[] = chr($min);
        }

        return $chars;
    }
}
