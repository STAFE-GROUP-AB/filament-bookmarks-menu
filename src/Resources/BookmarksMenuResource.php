<?php

namespace STAFEGROUPAB\FilamentBookmarksMenu\Resources;

use App\Models\User;
use STAFEGROUPAB\FilamentBookmarksMenu\Resources\BookmarksMenuResource\Pages;
use STAFEGROUPAB\FilamentBookmarksMenu\Resources\BookmarksMenuResource\RelationManagers;
use STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookmarksMenuResource extends Resource
{
    protected static ?string $model = BookmarksMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('menu_label')->label('Label')->required(),
                Forms\Components\TextInput::make('menu_url')->label('Url')->required()->url(),
                Forms\Components\Select::make('menu_target')->options([
                    '_self' => '_self',
                    '_top' => '_top',
                    '_blank' => 'New window/tab'
                ]),
                Forms\Components\TextInput::make('sort_order')->required()->numeric(),
                Forms\Components\Select::make('menu_user_id')->nullable()->label('User specific')->options(
                    User::all()->pluck('name', 'id')
                ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookmarksMenus::route('/'),
            'create' => Pages\CreateBookmarksMenu::route('/create'),
            'edit' => Pages\EditBookmarksMenu::route('/{record}/edit'),
        ];
    }
}
