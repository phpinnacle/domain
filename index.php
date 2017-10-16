<?php

use Acme\Command;
use Acme\Event;
use Acme\Registration;
use Acme\User;
use Acme\UserID;

include __DIR__ . '/vendor/autoload.php';

$users = [];

$listeners = [
    Event\UserNameChanged::class => [
        function (Event\UserNameChanged $event) {
            echo "Old user name: {$event->oldName}.\n";
            echo "New user name: {$event->newName}.\n";
        }
    ]
];

$handlers = [
    Command\RegisterUser::class => function (Command\RegisterUser $command) use (&$users) {
        $id = new UserID($command->id);
        $user = User::register($id, $command->name);

        $users[(string) $id] = $user;

        fire($user->pullEvents());
    },
    Command\ChangeUserName::class => function (Command\ChangeUserName $command) use (&$users) {
        /** @var User $user */
        $user = $users[$command->id];
        $user->changeName($command->name);

        fire($user->pullEvents());
    },
];

function fire(array $events): void
{
    global $listeners;

    foreach ($events as $event) {
        $handlers = $listeners[\get_class($event)] ?? [];

        foreach ($handlers as $handler) {
            $handler($event);
        }
    }
}

function handle(array $commands): void
{
    global $handlers;

    foreach ($commands as $command) {
        $handler = $handlers[\get_class($command)] ?? null;

        if (true === \is_callable($handler)) {
            $handler($command);
        }
    }
}

$registration = Registration::start('Eric');

foreach (Registration::subscribe() as $event) {
    $listeners[$event][] = [$registration, 'transition'];
}

$command = new Command\ChangeUserName();
$command->id   = (string) $registration->getID();
$command->name = 'Greg';

handle($registration->pullCommands());
handle([$command]);
