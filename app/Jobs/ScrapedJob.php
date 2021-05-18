<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\ArticleService;
use App\Models\Website;
use App\Events\ScrappedMessageEvent;
use App\Models\User;

class ScrapedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * articleService
     *
     * @var \App\Services\ArticleService
     */
    private ArticleService $articleService;

    /**
     * webiste
     *
     * @var \App\Models\Website
     */
    private Website $website;

    /**
     * link
     *
     * @var string
     */
    private string $link;

    /**
     * user
     *
     * @var \App\Models\User
     */
    private User $user;

    /**
     * Create a new job instance.
     *
     * @param \App\Services\ArticleService $articleService
     * @param string $link
     * @param \App\Models\Website $website
     * @param \App\Models\User   $user
     * @return void
     */
    public function __construct(ArticleService $articleService, string $link, Website $website, User $user)
    {
        $this->articleService = $articleService;
        $this->link           = $link;
        $this->website        = $website;
        $this->user           = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->articleService->CreatArticleFromLink($this->link, $this->website);
        //save user that make this job to can
        \Cache::add('user', $this->user, 60*60);
    }

    /**
     * Handle a job failure.
     *
     * @param \Throwable $exception
     *
     * @return void
     */
    public function failed(\Throwable $exception)
    {
      \File::append(storage_path('logs') . '/' . basename(get_class($this)) . '.log', $exception->getMessage().PHP_EOL);
      event(new ScrappedMessageEvent("failed", $exception->getMessage(), $this->user));
    }

}
