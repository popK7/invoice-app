<?php

namespace App\Providers;

use App\Models\Notification;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
        view()->composer('*', function ($view) {
            $notification = [];
            if (Sentinel::getUser()) {
                $user_id =Sentinel::getUser()->id;
                $notification = Notification::with(['user'])->where(['to_user'=>$user_id])->where('is_read','=',0)->take(10)->orderBy('id','desc')->get();
            }
            $data = [
                'notification' => $notification,
            ];
            $view->with($data);
        });
    }
}
