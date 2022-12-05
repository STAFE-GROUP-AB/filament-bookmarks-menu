<?php

namespace STAFEGROUPAB\FilamentBookmarksMenu\Resources\BookmarksMenuResource\Pages;

use STAFEGROUPAB\FilamentBookmarksMenu\Resources\BookmarksMenuResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookmarksMenu extends EditRecord
{
    protected static string $resource = BookmarksMenuResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
