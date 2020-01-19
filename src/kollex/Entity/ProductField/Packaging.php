<?php declare(strict_types=1);

namespace kollex\Entity\ProductField;

use MyCLabs\Enum\Enum;

class Packaging extends Enum
{
    /** @var string case */
    public const CA = 'CA';
    /** @var string box */
    public const BX = 'BX';
    /** @var string bottle */
    public const BO = 'BO';
}