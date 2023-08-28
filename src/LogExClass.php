<?php

namespace LoganSong\LogEx;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Str;

class LogExClass
{
  protected array $levels = [
    'debug'     => Logger::DEBUG,
    'info'      => Logger::INFO,
    'notice'    => Logger::NOTICE,
    'warning'   => Logger::WARNING,
    'error'     => Logger::ERROR,
    'critical'  => Logger::CRITICAL,
    'alert'     => Logger::ALERT,
    'emergency' => Logger::EMERGENCY,
    'query'     => Logger::NOTICE,
  ];

  public function __construct()
  {
  }

  protected function writeLog(string $_channel, string $_level, string $_message, array $_context = [])
  {
    $formatter = new LineFormatter("[%datetime%] %level_name%: %message%\n", 'H:i:s', true, true);

    if (Str::lower($_level) === 'query') {
      $path = sprintf('logs/%s/query.log', now()->format('Y-m-d'));
      $_level = 'notice';
    } else {
      $path = sprintf('logs/%s/%s.log', now()->format('Y-m-d'), $_channel);
    }

    $handler = new StreamHandler(storage_path($path));

    $handler->setFormatter($formatter);

    $orderLog = new Logger('dunkul');
    $orderLog->pushHandler($handler);
    $orderLog->{$_level}($_message, $_context);
  }

  protected function formatMessage($message)
  {
    if (is_array($message)) {
      return var_export($message, true);
    } elseif ($message instanceof Jsonable) {
      return $message->toJson();
    } elseif ($message instanceof Arrayable) {
      return var_export($message->toArray(), true);
    }

    return (string) $message;
  }

  public function __call(string $_level, array $_params)
  {
    if (in_array($_level, array_keys($this->levels)) && count($_params) > 1) {
      $this->writeLog($_params[0], $_level, $this->formatMessage($_params[1]));
    }
  }
}
