<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Contracts\Support\Renderable as Renderable;
use App\Http\Requests\ArticleUpdateFormRequest;
use App\Http\Requests\ArticleStoreFormRequest;
use App\Repositories\ArticleRepository;
use App\Services\ArticleStoreService;
use App\Services\ArticleUpdateService;
use App\Models\Article;

class ArticleController extends Controller implements FilterRequest
{
    /**
     * articleStoreService
     *
     * @var App\Services\ArticleStoreService
     */
    private $articleStoreService;

    /**
     * articleUpdateService
     *
     * @var App\Services\ArticleUpdateService
     */
    private $articleUpdateService;

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
     * @param App\Services\ArticleStoreService $articleStoreService
     * @param App\Services\ArticleUpdateService $articleUpdateService
     * @return void
     */
    public function __construct(
        ArticleRepository $articleRepository,
        ArticleStoreService $articleStoreService,
        ArticleUpdateService $articleUpdateService
    ) {
        $this->articleRepository     = $articleRepository  ;
        $this->articleStoreService   = $articleStoreService    ;
        $this->articleUpdateService  = $articleUpdateService    ;
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
     * store
     *
     * @param  App\Http\Requests\ArticleStoreFormRequest $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(ArticleStoreFormRequest $request): Renderable
    {
        $article = $this->articleStoreService->handle($request->validated());
        return response()->json(['data' => '' , 'status' => 'success' , 'message' => 'Article Added Successfully'], 204);
    }

    /**
     * edit
     *
     * @param  App\Models\Article $article
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Article $article): Renderable
    {
        if(!$article) {
        return response()->json(['status' => 'error' , 'data' => (object)[] , 'message' => 'Not ound Article'], 404);
        }
        return response()->json(['status' => 'success' , 'data' => new ArticleResource($article) , 'message' => 'Get Article For Edit Success'], 200);
    }

    /**
     * update
     *
     * @param  App\Http\Requests\ArticleUpdateFormRequest $request
     * @param  App\Models\Article $article
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(ArticleUpdateFormRequest $request,Article $article): Renderable
    {
        $article = $this->articleUpdateService->handle($request->validated(),$article);
        return response()->json(['status' => 'success' , 'data' => new ArticleResource($article) , 'message' => 'Update Article SuccessFully'], 200);
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

    /**
     * function that have all request that required to filter with it in article modul
     *
     * @return array
     */
    public function filterRequest(): array
    {
        return [
            "" => ""
        ];
    }
}
