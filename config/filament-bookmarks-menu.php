<?php

// config for STAFEGROUPAB/FilamentBookmarksMenu
return [

    // Icons to use for the icon you might add to your pages in
    // Filament Admin. Also the colors used for active and inactive.
    'bookmark_icon' => 'heroicon-o-bookmark',
    'bookmark_class' => 'w-5 h-5 cursor-pointer text-gray-700 dark:text-gray-200',
    'add_bookmark_icon' => 'heroicon-o-bookmark',
    'remove_bookmark_icon' => 'heroicon-s-bookmark',
    'add_bookmark_class' => 'w-6 h-6 cursor-pointer text-danger-700 dark:text-gray-200',
    'remove_bookmark_class' => 'w-6 h-6 cursor-pointer text-danger-700 dark:text-gray-200',
    'add_bookmarks_by_users' => true,
    'exclude_pages' => ['admin', 'bookmarks-menus'],
    'notification_add_icon' => 'heroicon-o-bookmark',
    'notification_remove_icon' => 'heroicon-o-bookmark',
    'notification_add_color' => 'success',
    'notification_remove_color' => 'danger',
    'show_resource_in_navigation' => false,
];
