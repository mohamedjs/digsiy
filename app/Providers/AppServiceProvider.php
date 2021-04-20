<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use App\Events\ScrappedMessageEvent;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Builder::macro('whereLike', function($attributes, string $searchTerm) {
            $this->where(function($q) use ($attributes,$searchTerm){
                foreach($attributes as $attribute) {
                  $q->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                }
            });
            return $this;
        });

        // make your own query file
        if(env('APP_DEBUG')) {
            \DB::listen(function($query){
                \File::append(
                    storage_path('logs/query.log'),
                    $query->sql . '[' . implode(', ', $query->bindings) . ']' . PHP_EOL
                );
            });
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Queue::after(function (JobProcessed $event) {
            match ($event->job->resolveName()) {
                "App\Jobs\ScrapedJob" => event(new ScrappedMessageEvent("success", "Success Scrapped Website")),
            };
        });

        // if job faild tell user the reason for that
        // Queue::failling(function (JobFailed $event){
        //     Log::error("error in event ". $event->exception->getMessage());
        // });
    }
}
