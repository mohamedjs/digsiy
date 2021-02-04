<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Contracts\Support\Renderable as Renderable;
use App\Repositories\ArticleRepository;
use App\Models\Article;

class ArticleController extends Controller implements FilterRequest
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
        $this->articleRepository     = $articleRepository  ;
    }

    /**
     * get all article with paginate
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): Renderable
    {
        $articles = $this->articleRepository->filter($this->articleFilters())
                ->paginate(request('per_page', 10));

        return response()->json(['status' => 'success' , 'data' => new ArticleCollection($articles) , 'message' => 'Get All Article'], 200);
    }

    /**
     * destroy
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy($id): Renderable
    {
        $article = $this->articleRepository->find($id)->delete();
        return response()->json(['status' => 'success' , 'data' => (object)[] , 'message' => 'Delete Article SuccessFully'] ,201);
    }
}
