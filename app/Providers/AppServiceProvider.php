<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\inforcontact;
use App\order;
use App\sale;
use App\category_product;
use App\infor_website;
use App\product;
use App\news;

use Illuminate\Support\Facades\Auth;
use App\category_policy;

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
        view()->composer('*',function($view){
            $view->with([
                'data_unique'=> infor_website::all(),
                'message_unique' => inforcontact::where('status',0)->count(),
                'order_unique' => order::where('id_status',1)->orWhere('id_status',3)->count(),
                'order_new_unique' => order::where('id_status',1)->count(),
                'categories_unique' => category_product::all(),
                'categorypolicy_unique' => category_policy::all(),
                'notifyforcensorproduct_unique' => product::where('status',0)->count(),
                'notifyforcensornews_unique' => news::where('status',0)->count(),
            ]);
            if(Auth::check()){
                $view->with([
                    'notifyforsaler_unique' => sale::where('id_saler',Auth::user()->id)->where('status',0)->count(),
                ]);
            }
        });
    }
}
