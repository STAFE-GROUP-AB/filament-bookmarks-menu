# Filament Bookmarks Menu for Filament Admin

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stafe-group-ab/filament-bookmarks-menu.svg?style=flat-square)](https://packagist.org/packages/stafe-group-ab/filament-bookmarks-menu)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/stafe-group-ab/filament-bookmarks-menu/run-tests?label=tests)](https://github.com/stafe-group-ab/filament-bookmarks-menu/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/stafe-group-ab/filament-bookmarks-menu/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/stafe-group-ab/filament-bookmarks-menu/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/stafe-group-ab/filament-bookmarks-menu.svg?style=flat-square)](https://packagist.org/packages/stafe-group-ab/filament-bookmarks-menu)

This Filament Plugin will add a bookmarks menu to your Filament Admin application. You can setup global items in this menu or let users add their own items.

## Installation

You can install the package via composer:

```bash
composer require stafe-group-ab/filament-bookmarks-menu
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-bookmarks-menu-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-bookmarks-menu-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-bookmarks-menu-views"
```

## Usage
To offer your logged in users the ability to add favorites to their personal bookmarks menu just add the code below to any Filament Resource Page. You must ofcourse 
modify the code, labels and such as you can understand.
```php
protected function getActions(): array
    {
        return [
            Action::make('settings')->action('createBookmarksMenu')->label('Ny Favorit')->icon('heroicon-o-bookmark')->color('danger'),
        ];
    }

    public function createBookmarksMenu(): void
    {
       $bmu = new BookmarksMenu();
       $bmu->menu_label = 'Create User';
       $bmu->menu_url = ENV('APP_URL') . '/admin/users/create';
       $bmu->menu_user_id = Auth::user()->id;
       $bmu->sort_order = 99;
       $bmu->save();

        Notification::make()
            ->title('New Bookmark saved successfully to your personal menu')
            ->icon('heroicon-o-bookmark')
            ->iconColor('success')
            ->send();

        $this->redirect($this->previousUrl);

    }

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Andreas Kviby, Stafe Group](https://github.com/STAFE-GROUP-AB)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
