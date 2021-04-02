<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\ArticleService;
use App\Models\Website;

class ScrapedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * articleService
     *
     * @var App\Services\ArticleService
     */
    private $articleService;

    /**
     * webiste
     * 
     * @var App\Models\Website
     */
    private $website;

    /**
     * link
     * 
     * @var string
     */
    private $link;

    /**
     * Create a new job instance.
     *
     * @param App\Services\ArticleService $articleService
     * @param string $link
     * @param App\Models\Website $website
     * @return void
     */
    public function __construct(ArticleService $articleService, string $link, Website $website)
    {
        $this->articleService = $articleService;
        $this->link           = $link;
        $this->website        = $website;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->articleService->CreatArticleFromLink($this->link, $this->website);
    }
}
