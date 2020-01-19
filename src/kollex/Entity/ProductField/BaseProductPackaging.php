<?php declare(strict_types=1);

namespace kollex\Entity\ProductField;

use MyCLabs\Enum\Enum;

class BaseProductPackaging extends Enum
{
    /** @var string bottle */
    public const BO = 'BO';
    /** @var string can */
    public const CN = 'CN';
}