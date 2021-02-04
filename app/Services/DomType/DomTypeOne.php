<?php

namespace App\Services\DomType;

use App\Contracts\DomTypeContract\DomType;
use PHPHtmlParser\Dom;

class DomTypeOne implements DomType
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
        $contents = $dom->find('.post-item');
        $data = [];
        foreach ($contents as $key => $content)
        {
            $data[$key]['title']       = $content->find('.post-title a')->innerHtml;
            $data[$key]['description'] = $content->find('.post-excerpt')->innerHtml;
            $data[$key]['url']         = $content->find('.post-title a')->getAttribute("href");
            $data[$key]['dom']         = $content->outerHtml;
        }
        return $data;
    }
}
