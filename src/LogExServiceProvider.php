<?php

namespace LoganSong\LogEx;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class LogExServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind('LogEx', function () {
      return new LogExClass(new Request);
    });
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }
}
