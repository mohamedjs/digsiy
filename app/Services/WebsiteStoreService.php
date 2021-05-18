<?php

namespace App\Services;

use App\Repositories\WebsiteRepository;
use App\Models\Website;
use App\Jobs\ScrapedJob;

class WebsiteStoreService
{
    /**
     * websiteRepository
     *
     * @var \App\Repositories\WebsiteRepository
     */
    private $websiteRepository;

    /**
     * articleService
     *
     * @var \App\Services\ArticleService
     */
    private $articleService;

    /**
     * __construct
     *
     * @param \App\Repositories\WebsiteRepository $websiteRepository
     * @param \App\Services\ArticleService        $articleService
     *
     * @return void
     */
    public function __construct(WebsiteRepository $websiteRepository, ArticleService $articleService)
    {
        $this->websiteRepository = $websiteRepository;
        $this->articleService    = $articleService;
    }

    /**
     * handle function that make update for website
     *
     * @param array $request
     *
     * @return \App\Models\Website
     */
    public function handle($request): Website
    {
        $request['last_scraped_at'] = date("Y-m-d H:i:s");
        $website = $this->websiteRepository->create($request);
        dispatch(new ScrapedJob($this->articleService, $request['link'], $website, auth()->user()));
    	return $website;
    }

}
