<?php

namespace App\Repositories;

use App\Models\Website;
use Illuminate\Http\Request;
use Closure;

class WebsiteRepository
{
    /**
     * website
     *
     * @var \App\Models\Website
     */
    private $website;

    /**
     * __construct
     *
     * @param \App\Models\Website $website
     * @return void
     */
    public function __construct(Website $website)
    {
        $this->website = $website;
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
        return call_user_func_array([$this->website, $method], $args);
    }
}
