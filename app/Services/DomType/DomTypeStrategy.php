<?php

namespace App\Services\DomType;

use App\Contracts\DomTypeContract\DomType;

class DomTypeStrategy
{
    /**
     * domType
     *
     * @var App\Contracts\DomTypeContract\DomType
     */
    private $domType;

    /**
     * Method __construct
     *
     * @param DomType $domType
     *
     * @return void
     */
    public function __construct(DomType $domType)
    {
        $this->domType = $domType;
    }

    /**
     * Method collectArticlesDataFromLink
     *
     * @param string $link
     *
     * @return array
     */
    public function collectArticlesDataFromLink($link): array
    {
        return $this->domType->handle($link);
    }
}
