<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Contracts\Support\Renderable as Renderable;
use Illuminate\Http\RedirectResponse as RedirectResponse;
use App\Http\Requests\WebsiteStoreFormRequest;
use App\Repositories\WebsiteRepository;
use App\Services\WebsiteStoreService;
use App\Services\WebsiteUpdateService;
use App\Models\Website;

class WebsiteController extends Controller
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
        $websites = $this->websiteRepository->get();

        return view("website.index", compact('websites'));
    }

    /**
     * create
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(): Renderable
    {
        return view("website.create");
    }

    /**
     * store
     *
     * @param  App\Http\Requests\WebsiteStoreFormRequest $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(WebsiteStoreFormRequest $request): RedirectResponse
    {
        try {
            $website = $this->websiteStoreService->handle($request->validated());
            return redirect(route("admin.websites.index"))->with("success", "Scraped Done");
        } catch (\Throwable $e) {
            \Log::error($e);
             return redirect(route("admin.websites.index"))->with("error", "there is error when scraped website");
        }
    }

    /**
     * update
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Website $website
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(request $request,Website $website): RedirectResponse
    {
        try {
            $website = $this->websiteUpdateService->handle($request->all(), $website);
            return back()->with("success","Scraped Done");
        } catch (\Throwable $e) {
            \Log::error($e);
             return redirect(route("admin.websites.index"))->with("error", "there is error when scraped website");
        }
    }
}
