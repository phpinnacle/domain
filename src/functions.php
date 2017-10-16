<?php
/*
 * This file is part of PHPinnacle/Domain.
 *
 * (c) PHPinnacle Team <dev@phpinnacle.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function get_class_name($object): string
{
    if (false === \is_object($object)) {
        throw new \InvalidArgumentException();
    }

    $class = \get_class($object);

    return \substr($class, (\strrpos($class, '\\') ?: -1) + 1);
}
