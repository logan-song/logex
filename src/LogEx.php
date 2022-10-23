<?php

namespace LoganSong\LogEx;

use Illuminate\Support\Facades\Facade;

class LogEx extends Facade
{
  protected static function getFacadeAccessor()
  {
    return 'LogEx';
  }
}
