<?php

namespace App\Services\DomType;

use App\Contracts\DomTypeContract\DomType;
use PHPHtmlParser\Dom;

class DomTypeTwo implements DomType
{
    /**
     * get Article from Website That Needed To Scrapped
     *
     * @param string $link [website link that needed to scrapped]
     *
     * @return array
     */
    public function handle($link): array
    {
        $dom = new Dom();
        $dom->loadFromUrl($link);
        $contents = $dom->find('.item-list');
        $data = [];
        foreach ($contents as $key=>$content)
        {
            $data[$key]['title']       = $content->find('.post-box-title a')->innerHtml;
            $data[$key]['description'] = $content->find('.entry p')->innerHtml;
            $data[$key]['link']         = $content->find('.post-box-title a')->getAttribute("href");
            $data[$key]['dom']         = $content->outerHtml;
        }
        return $data;
    }
}
