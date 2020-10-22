<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    // 追加
    \Schema::defaultStringLength(191);
    // \URL::forceScheme('https');
    if (request()->isSecure()) {
      \URL::forceScheme('https');
    }
  }
}
