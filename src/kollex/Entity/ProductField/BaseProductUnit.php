<?php declare(strict_types=1);

namespace kollex\Entity\ProductField;

use MyCLabs\Enum\Enum;

class BaseProductUnit extends Enum
{
    /** @var string liters */
    public const LT = 'LT';
    /** @var string grams */
    public const GR = 'GR';
}