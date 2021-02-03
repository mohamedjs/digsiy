<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Contracts\Support\Renderable as Renderable;
use App\Http\Requests\Api\Admin\WebsiteUpdateFormRequest;
use App\Http\Requests\Api\Admin\WebsiteStoreFormRequest;
use App\Repositories\WebsiteRepository;
use App\Services\WebsiteStoreService;
use App\Services\WebsiteUpdateService;
use App\Models\Website;

class WebsiteController extends Controller implements FilterRequest
{
    /**
     * websiteStoreService
     *
     * @var App\Services\WebsiteStoreService
     */
    private $websiteStoreService;

    /**
     * websiteUpdateService
     *
     * @var App\Services\WebsiteUpdateService
     */
    private $websiteUpdateService;

    /**
     * websiteRepository
     *
     * @var App\Repositories\WebsiteRepository
     */
    private $websiteRepository;

    /**
     * Method __construct
     *
     * @param App\Repositories\WebsiteRepository $websiteRepository
     * @param App\Services\WebsiteStoreService $websiteStoreService
     * @param App\Services\WebsiteUpdateService $websiteUpdateService
     * @return void
     */
    public function __construct(
        WebsiteRepository $websiteRepository,
        WebsiteStoreService $websiteStoreService,
        WebsiteUpdateService $websiteUpdateService
    ) {
        $this->websiteRepository     = $websiteRepository  ;
        $this->websiteStoreService   = $websiteStoreService    ;
        $this->websiteUpdateService  = $websiteUpdateService    ;
    }

    /**
     * get all website with paginate
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): Renderable
    {
        $websites = $this->websiteRepository->filter($this->websiteFilters())
                ->paginate(request('per_page', 10));

        return response()->json(['status' => 'success' , 'data' => new WebsiteCollection($websites) , 'message' => 'Get All Website'], 200);
    }

    /**
     * store
     *
     * @param  App\Http\Requests\WebsiteStoreFormRequest $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(WebsiteStoreFormRequest $request): Renderable
    {
        $website = $this->websiteStoreService->handle($request->validated());
        return response()->json(['data' => '' , 'status' => 'success' , 'message' => 'Website Added Successfully'], 204);
    }

    /**
     * edit
     *
     * @param  App\Models\Website $website
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Website $website): Renderable
    {
        if(!$website) {
        return response()->json(['status' => 'error' , 'data' => (object)[] , 'message' => 'Not ound Website'], 404);
        }
        return response()->json(['status' => 'success' , 'data' => new WebsiteResource($website) , 'message' => 'Get Website For Edit Success'], 200);
    }

    /**
     * update
     *
     * @param  App\Http\Requests\WebsiteUpdateFormRequest $request
     * @param  App\Models\Website $website
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(WebsiteUpdateFormRequest $request,Website $website): Renderable
    {
        $website = $this->websiteUpdateService->handle($request->validated(),$website);
        return response()->json(['status' => 'success' , 'data' => new WebsiteResource($website) , 'message' => 'Update Website SuccessFully'], 200);
    }

    /**
     * destroy
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy($id): Renderable
    {
        $website = $this->websiteRepository->find($id)->delete();
        return response()->json(['status' => 'success' , 'data' => (object)[] , 'message' => 'Delete Website SuccessFully'] ,201);
    }

    /**
     * function that have all request that required to filter with it in website modul
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
