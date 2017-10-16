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

class UndefinedTransition extends DomainException
{
    /**
     * @param object $saga
     * @param object $event
     */
    public function __construct($saga, $event)
    {
        parent::__construct(sprintf('Saga "%s" doesn\'t define transition for event "%s".',
            \get_class($saga),
            \get_class($event)
        ));
    }
}
