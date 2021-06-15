<?php


namespace Penguin\ConsoleApp;


class App
{
    public string $commandName;

    public function __construct()
    {
        $this->commandName = $_SERVER['argv'][1] ?? 'scan';
    }

    public function run(): void
    {
        $commands = new Commands();
        if (!method_exists($commands, $this->commandName)) {
            throw new \Exception('Command not found');
        }

        call_user_func([$commands,$this->commandName]);
    }
}