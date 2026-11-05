<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\LoggerInterface;
use RuntimeException;

class FileLogger implements LoggerInterface
{
    public function log(string $message): void
    {
        $directory = dirname(__DIR__, 2).'/storage/logs';

        if (! is_dir($directory)) {
            if (! mkdir($directory, 0775, true) && ! is_dir($directory)) {
                throw new RuntimeException(
                    'Не вдалося створити директорію логів'
                );
            }
        }

        $logFile = $directory.'/app.log';

        $entry = '[FILE] '.date('Y-m-d H:i:s')
            .' | '.$message.PHP_EOL;

        if (file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX) === false) {
            throw new RuntimeException(
                'Не вдалося записати повідомлення у файл'
            );
        }
    }
}
