<?php


namespace Penguin\ConsoleApp;


class Helpers
{
    public static function getFiles(string $folder): array
    {
        $contents = array_slice(scandir($folder), 2);
        $files = [];

        foreach ($contents as $content) {
            $fullPathContent = $folder . '/' . $content;
            if (is_dir($fullPathContent)) {
                $files = array_merge($files, self::getFiles($fullPathContent));
            } else {
                $files[] = $fullPathContent;
            }
        }

        return $files;
    }
}