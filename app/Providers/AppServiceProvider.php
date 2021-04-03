<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use App\Events\ScrappedMessageEvent;

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

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Queue::after(function (JobProcessed $event) {
          switch ($event->job->resolveName()) {
            case "App\Jobs\ScrapedJob":
              event(new ScrappedMessageEvent("success", "Success Scrapped Website"));
            default:
              break;
          }
        });
    }
}
