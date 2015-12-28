<?php namespace Redooor\Redminstore\App\Models\UI;

use Redooor\Redminportal\App\Models\Page;

class Menu
{
    /**
    /* Get all pages.
    /*
    /* @param bool $private To retrieve private or public pages, default public.
    /* @return array(Page) or null if nothing found
     */
    public static function getPages($private = false)
    {
        $pages = Page::where('private', $private)->get();
        
        return $pages;
    }
}