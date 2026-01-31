# Filament rich editor source code

[![Latest Version on Packagist](https://img.shields.io/packagist/v/curder/filament-rich-editor-source-code.svg?style=flat-square)](https://packagist.org/packages/curder/filament-rich-editor-source-code)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/curder/filament-rich-editor-source-code/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/curder/filament-rich-editor-source-code/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/curder/filament-rich-editor-source-code/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/curder/filament-rich-editor-source-code/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/curder/filament-rich-editor-source-code.svg?style=flat-square)](https://packagist.org/packages/curder/filament-rich-editor-source-code)

Allow Filament 4.x Or 5.x View and edit the source code of the rich text editor in the form field.

## Installation

You can install the package via composer:

```bash
composer require curder/filament-rich-editor-source-code
```

## Usage

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

```bash
composer test
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
