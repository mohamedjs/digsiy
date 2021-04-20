<?php

namespace App\Services;

use App\Repositories\WebsiteRepository;
use App\Models\Website;
use App\Jobs\ScrapedJob;

class WebsiteUpdateService
{
    /**
     * websiteRepository
     *
     * @var App\Repositories\WebsiteRepository
     */
    private $websiteRepository;

     /**
     * articleService
     *
     * @var App\Services\ArticleService
     */
    private $articleService;

     /**
     * __construct
     *
     * @param App\Repositories\WebsiteRepository $websiteRepository
     * @param App\Services\ArticleService         $articleService
     *
     * @return void
     */
    public function __construct(WebsiteRepository $websiteRepository, ArticleService $articleService)
    {
        $this->websiteRepository      = $websiteRepository;
        $this->articleService         = $articleService;
    }

    /**
     * handle function that make update for website
     *
     * @param array $request
     *
     * @param App\Models\Website   $website
     *
     * @return App\Models\Website
     */
    public function handle($request, $website): Website
    {
        $request['last_scraped_at'] = date("Y-m-d H:i:s");
        
        $website = tap($website)->update($request);

        dispatch(new ScrapedJob($this->articleService, $website->link, $website));
        // $this->articleService->CreatArticleFromLink($website->link, $website);
        
    	return $website;
    }

}
