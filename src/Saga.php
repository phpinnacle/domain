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

namespace PHPinnacle\Domain;

abstract class Saga implements Entity, EventProvider, Versioned
{
    use
        Traits\EventProviderTrait,
        Traits\VersionedTrait
    ;

    public const
        HANDLE_PREFIX = 'when'
    ;

    public const
        STATE_PROCESSING = 0,
        STATE_COMPLETED  = 1,
        STATE_FAILED     = 2
    ;

    /**
     * @var ID
     */
    private $id;

    /**
     * @var int
     */
    private $status = self::STATE_PROCESSING;

    /**
     * @var array
     */
    private $commands = [];

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
     * Transition saga to new state
     *
     * Store event data internally and
     * try to call corresponding `when` method
     *
     * @param object $event
     *
     * @return void
     * @throws Exception\InvalidEvent
     * @throws Exception\UndefinedTransition
     */
    public function transition($event): void
    {
        $this->apply($event, self::HANDLE_PREFIX);

        $this->version++;
    }

    /**
     * Schedule command to run
     *
     * @param object $command
     *
     * @return void
     * @throws Exception\InvalidCommand
     */
    public function fire($command): void
    {
        Guard::command($command);

        $this->commands[] = $command;
    }

    /**
     * @param array $payload
     *
     * @return void
     */
    public function complete(array $payload = []): void
    {
        $this->fire(new Event\SagaCompleted($this, $payload));
    }

    /**
     * @param \Exception $error
     * @param array      $payload
     *
     * @return void
     */
    public function fail(\Exception $error = null, array $payload = []): void
    {
        $this->fire(new Event\SagaFailed($this, $payload, $error));
    }

    /**
     * {@inheritdoc}
     */
    public function pullCommands(): array
    {
        $commands = $this->commands;

        $this->commands = [];

        return $commands;
    }

    /**
     * @param Event\SagaCompleted $event
     *
     * @return void
     */
    protected function whenSagaCompleted(Event\SagaCompleted $event): void
    {
        $this->status = self::STATE_COMPLETED;
    }

    /**
     * @param Event\SagaFailed $event
     *
     * @return void
     */
    protected function whenSagaFailed(Event\SagaFailed $event): void
    {
        $this->status = self::STATE_FAILED;
    }
}
