<?php

namespace STAFEGROUPAB\FilamentBookmarksMenu\Commands;

use Illuminate\Console\Command;

class FilamentBookmarksMenuCommand extends Command
{
    public $signature = 'filament-bookmarks-menu';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
