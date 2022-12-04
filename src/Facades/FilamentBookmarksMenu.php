<?php

namespace STAFEGROUPAB\FilamentBookmarksMenu\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \STAFEGROUPAB\FilamentBookmarksMenu\FilamentBookmarksMenu
 */
class FilamentBookmarksMenu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \STAFEGROUPAB\FilamentBookmarksMenu\FilamentBookmarksMenu::class;
    }
}
