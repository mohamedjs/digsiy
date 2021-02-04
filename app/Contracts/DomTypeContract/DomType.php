<?php

namespace App\Contracts\DomTypeContract;

interface DomType
{
    /**
     * get Article from Website That Needed To Scrapped
     *
     * @param string $link [website link that needed to scrapped]
     *
     * @return array
     */
    public function handle($link): array ;
}
