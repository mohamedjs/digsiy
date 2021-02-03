<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Http\Request;
use Closure;

class ArticleRepository
{
    /**
     * article
     *
     * @var App\Models\Article
     */
    private $article;

    /**
     * __construct
     *
     * @param  Article $article
     * @return void
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Magic Function  __call
     *
     * @param  \Closure $method
     * @param  mixed $arguments
     * @return mixed
     */
    public function __call($method, $args) : mixed
    {
        return call_user_func_array([$this->article, $method], $args);
    }
}
