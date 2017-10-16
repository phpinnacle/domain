<?php
/*
 * This file is part of PHPinnacle/Domain.
 *
 * (c) PHPinnacle Team <dev@phpinnacle.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPinnacle\Domain;

final class Guard
{
    /**
     * @param mixed $value
     *
     * @throws Exception\InvalidCommand
     */
    public static function command($value): void
    {
        if (false === self::message($value)) {
            throw new Exception\InvalidCommand($value);
        }
    }

    /**
     * @param mixed $value
     *
     * @throws Exception\InvalidEvent
     */
    public static function event($value): void
    {
        if (false === self::message($value)) {
            throw new Exception\InvalidEvent($value);
        }
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    private static function message($value): bool
    {
        return \is_object($value) and
            (false === $value instanceof \Closure) and
            (false === $value instanceof \Generator)
        ;
    }
}
