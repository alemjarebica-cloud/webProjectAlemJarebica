<?php

class Logger
{
    private static function write(string $file, string $level, string $message): void
    {
        $dir = __DIR__ . '/../logs';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $line = '[' . date('Y-m-d H:i:s') . "] $level $message\n";
        file_put_contents("$dir/$file", $line, FILE_APPEND | LOCK_EX);
    }

    public static function info(string $message): void
    {
        self::write('info.log', 'INFO', $message);
    }

    public static function error(string $message): void
    {
        self::write('error.log', 'ERROR', $message);
    }
}