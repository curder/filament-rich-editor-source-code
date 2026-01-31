# Filament rich editor source code

[![Latest Version on Packagist](https://img.shields.io/packagist/v/curder/filament-rich-editor-source-code.svg?style=flat-square)](https://packagist.org/packages/curder/filament-rich-editor-source-code)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/curder/filament-rich-editor-source-code/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/curder/filament-rich-editor-source-code/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/curder/filament-rich-editor-source-code/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/curder/filament-rich-editor-source-code/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/curder/filament-rich-editor-source-code.svg?style=flat-square)](https://packagist.org/packages/curder/filament-rich-editor-source-code)

Allow Filament 4.x Or 5.x View and edit the source code of the rich text editor in the form field.

## Installation

You can install the package via composer:

```shell
composer require curder/filament-rich-editor-source-code
```

You need to publish the package assets using the following command:

```shell
php artisan filament:assets
```

You can publish the language files using the following command:

```shell
php artisan vendor:publish --tag=filament-rich-editor-source-code-translations
```

## Usage

To enable the source code button in the Filament Rich Editor, you need to customize the toolbar buttons by adding the `source-code` button to the array of toolbar buttons.

```php
RichEditor::make('html')
    ->toolbarButtons([
        ['source-code'], // Add the `source-code` button to the toolbar.
        [ 'bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
        ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
        ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
        ['table', 'attachFiles', 'customBlocks'], // The `customBlocks` and `mergeTags` tools are also added here if those features are used.
        ['undo', 'redo'],
    ]),
```

## Testing

```shell
composer test
```

## Development

You can set up the development environment by running the following commands:

Add the following script to your `composer.json` to require the development dependencies:

```json
{
    "require": {
        "php": "^8.2",
        "curder/filament-rich-editor-source-code": "@dev",
        "filament/filament": "^5.0",
        "laravel/framework": "^12.0",
        "laravel/tinker": "^2.10.1"
    },
    "repositories": [
        {"type": "path", "url": "/Users/curder/Codes/GitHub/curder/filament-rich-editor-source-code"}
    ]
}
```

Then run:

```shell
composer update curder/filament-rich-editor-source-code
```

If you change js file, should run the following commands to install dependencies and build assets:

```shell
# Install the dependencies
pnpm i 

# Build the assets initially
node ./bin/build.js
```

And run the following command to your project directory update the assets after changing js files:

```shell
php artisan filament:assets
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

PRs are welcome.

- Keep changes focused.
- Include tests if behavior changes.

## Security

If you discover a security issue, please report it privately by emailing the maintainer.

## Credits

- [curder](https://github.com/Curder)

## License

MIT. See [LICENSE](LICENSE.md).
