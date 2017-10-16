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

abstract class AggregateRoot implements Entity, EventProvider, Versioned
{
    use
        Traits\EventProviderTrait,
        Traits\VersionedTrait
    ;

    /**
     * @var ID
     */
    private $id;

    /**
     * @param ID $id
     */
    public function __construct(ID $id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getID(): ID
    {
        return $this->id;
    }

    /**
     * Raise event for AR
     *
     * Store event data internally and
     * try to call corresponding `apply` method
     *
     * @param object $event
     *
     * @return void
     * @throws Exception\InvalidEvent
     */
    protected function raise($event): void
    {
        $this->apply($event);

        $this->version++;
    }
}
