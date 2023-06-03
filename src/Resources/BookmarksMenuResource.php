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
use Filament\Forms\Components\Card;

class BookmarksMenuResource extends Resource
{
    protected static ?string $model = BookmarksMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $recordTitleAttribute = "menu_label";
    //protected static bool $shouldRegisterNavigation = !!;
    protected static function shouldRegisterNavigation(): bool
    {
        return config('filament-bookmarks-menu.show_resource_in_navigation', true);
    }
    public static function form(Form $form): Form
    {
        $userModel = config('filament-bookmarks-menu.user_model', User::class);
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('menu_label')->label(__('filament-bookmarks-menu::filament-bookmarks-menu.resource.form.label'))->required(),
                        Forms\Components\TextInput::make('menu_url')->label(__('filament-bookmarks-menu::filament-bookmarks-menu.resource.form.url'))->required()->url(),
                        Forms\Components\Select::make('menu_target')->options([
                            '_self' => __('filament-bookmarks-menu::filament-bookmarks-menu.resource.form.target.self'),
                            '_top' => __('filament-bookmarks-menu::filament-bookmarks-menu.resource.form.target.top'),
                            '_blank' => __('filament-bookmarks-menu::filament-bookmarks-menu.resource.form.target.blank')
                        ])->placeholder(__('filament-bookmarks-menu::filament-bookmarks-menu.resource.form.target.placeholder.label'))
                            ->label(__('filament-bookmarks-menu::filament-bookmarks-menu.resource.form.target')),
                        Forms\Components\TextInput::make('sort_order')->required()->numeric()->label(__('filament-bookmarks-menu::filament-bookmarks-menu.resource.form.sort_order'))->default(0),
                        Forms\Components\Select::make('menu_user_id')->nullable()->label(__('filament-bookmarks-menu::filament-bookmarks-menu.resource.form.user'))->options(
                            $userModel::all()->pluck('name', 'id')
                        )->placeholder(__('filament-bookmarks-menu::filament-bookmarks-menu.resource.form.user.placeholder.label')),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('menu_label')->label(trans('filament-bookmarks-menu::filament-bookmarks-menu.resource.table.label'))->sortable()->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('menu_url')->label(trans('filament-bookmarks-menu::filament-bookmarks-menu.resource.table.url'))->sortable()->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('menu_target')->label(trans('filament-bookmarks-menu::filament-bookmarks-menu.resource.table.target'))->sortable()->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('sort_order')->label(trans('filament-bookmarks-menu::filament-bookmarks-menu.resource.table.sort_order'))->sortable()->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('user.name')->label(trans('filament-bookmarks-menu::filament-bookmarks-menu.resource.table.user'))->sortable()->searchable()->toggleable(),
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
    public static function getModelLabel(): string
    {
        return __('filament-bookmarks-menu::filament-bookmarks-menu.resource.label.bookmark');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-bookmarks-menu::filament-bookmarks-menu.resource.label.bookmarks');
    }
    protected static function getNavigationLabel(): string
    {
        return __('filament-bookmarks-menu::filament-bookmarks-menu.nav.label');
    }

    protected static function getNavigationIcon(): string
    {
        return __('filament-bookmarks-menu::filament-bookmarks-menu.nav.icon');
    }
}
