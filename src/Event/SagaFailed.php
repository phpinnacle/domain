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

class SagaFailed extends SagaEvent
{
    /**
     * @var string
     */
    public $reason;

    /**
     * @var int
     */
    public $code;

    /**
     * @var string
     */
    public $message;

    /**
     * @param Saga       $saga
     * @param array      $payload
     * @param \Exception $error
     */
    public function __construct(Saga $saga, array $payload = [], \Exception $error = null)
    {
        parent::__construct($saga, $payload);

        if (null !== $error) {
            $this->reason  = \get_class($error);
            $this->code    = (int) $error->getCode();
            $this->message = (string) $error->getMessage();
        }
    }
}
