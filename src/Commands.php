<?php


namespace Penguin\ConsoleApp;


class Commands
{
    public function scan()
    {
        $config = json_decode(file_get_contents(__DIR__ . '/../config.json'), true);
        $files = Helpers::getFiles(__DIR__ . '/../' . $config['folder'], $config['ext']);
        Helpers::convertToPdf($files);
    }
}