<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Contracts\Support\Renderable as Renderable;
use App\Repositories\ArticleRepository;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * articleRepository
     *
     * @var App\Repositories\ArticleRepository
     */
    private $articleRepository;

    /**
     * Method __construct
     *
     * @param App\Repositories\ArticleRepository $articleRepository
     *
     * @return void
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository  ;
    }

    /**
     * get all article with paginate
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request): Renderable
    {
        $articles = $this->articleRepository->query();

        if($request->filled("website_id")) {
            $articles = $articles->where("website_id", $request->website_id);
        }

        $articles = $articles->get();

        return view("article.index", compact('articles'));
    }
}
