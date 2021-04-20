<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use App\Services\DomType\DomTypeOne;
use App\Services\DomType\DomTypeTwo;
use App\Services\DomType\DomTypeStrategy;
use App\Constants\DomType;
use App\Models\Website;

class ArticleService
{
    /**
     * articleRepository
     *
     * @var \App\Repositories\ArticleRepository
     */
    private $articleRepository;

    /**
     * __construct
     *
     * @param \App\Repositories\ArticleRepository $articleRepository
     * @return void
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Creat Article From Link
     *
     * @param string             $request
     * @param \App\Models\Website $website
     *
     * @return void
     */
    public function CreatArticleFromLink($link, $website)
    {
        if(strpos($link ,"mklat") !== false) {
            $DomTypeClass = sprintf("App\\Services\\DomType\\".DomType::ONE);
        }
        if(strpos($link ,"arabmediasociety") !== false) {
            $DomTypeClass = sprintf("App\\Services\\DomType\\".DomType::TWO);
        }

        $DomTypeStrategy  = new DomTypeStrategy(new $DomTypeClass);

        $articles = $DomTypeStrategy->collectArticlesDataFromLink($link);

        $website->articles()->delete();
        $website->articles()->createMany($articles);
    }

}
