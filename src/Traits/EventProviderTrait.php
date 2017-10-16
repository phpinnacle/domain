<?php
/*
 * This file is part of PHPinnacle/Domain.
 *
 * (c) PHPinnacle Team <dev@phpinnacle.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PHPinnacle\Domain\Traits;

use PHPinnacle\Domain\Guard;

trait EventProviderTrait
{
    /**
     * @var object[]
     */
    private $events = [];

    /**
     * @see \PHPinnacle\Domain\EventProvider::pullEvents()
     */
    public function pullEvents(): array
    {
        $events = $this->events;

        $this->events = [];

        return $events;
    }

    /**
     * @param object $event
     * @param string $prefix
     *
     * @return void
     */
    private function apply($event, $prefix = 'apply'): void
    {
        Guard::event($event);

        $handler = $prefix . \get_class_name($event);

        if (false === \method_exists($this, $handler)) {
            return;
        }

        $this->{$handler}($event);

        $this->events[] = $event;
    }
}
