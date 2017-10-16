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

namespace PHPinnacle\Domain\Event;

use PHPinnacle\Domain\Saga;

abstract class SagaEvent
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $type;

    /**
     * @var int
     */
    public $version;

    /**
     * @var array
     */
    public $payload;

    /**
     * @param Saga  $saga
     * @param array $payload
     */
    public function __construct(Saga $saga, array $payload = [])
    {
        $this->id      = (string) $saga->getID();
        $this->type    = \get_class($saga);
        $this->version = $saga->getVersion();
        $this->payload = $payload;
    }
}
