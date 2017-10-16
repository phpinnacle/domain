<?php
/*
 * This file is part of PHPinnacle/Domain.
 *
 * (c) PHPinnacle Team <dev@phpinnacle.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPinnacle\Domain\Exception;

class InvalidCommand extends DomainException
{
    /**
     * @param mixed $event
     */
    public function __construct($event)
    {
        parent::__construct(sprintf('Command must be object, got: %s',
            \is_object($event) ? \get_class($event) : \gettype($event)
        ));
    }
}
