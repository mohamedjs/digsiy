<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use App\Models\Website;

class ArticleService
{
    /**
     * articleRepository
     *
     * @var App\Repositories\ArticleRepository
     */
    private $articleRepository;

    /**
     * __construct
     *
     * @param App\Repositories\ArticleRepository $articleRepository
     * @return void
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository      = $articleRepository;
    }

    /**
     * Creat Article From Link
     *
     * @param string             $request
     * @param App\Models\Website $website
     *
     * @return void
     */
    public function CreatArticleFromLink($link, $website)
    {
        if($link = 1) {
            $DomTypeClass = sprintf("App\\Services\\DomType".DomType::One);
        }
        if($link = 2) {
            $DomTypeClass = sprintf("App\\Services\\DomType".DomType::Two);
        }

        $DomTypeStrategy  = new DomTypeStrategy(new $DomTypeClass);

        $articles = $DomTypeStrategy->collectArticlesDataFromLink($request['link']);

        $website->articles()->delete();
        $this->articleRepository->insertMany($articles);
    }

}
