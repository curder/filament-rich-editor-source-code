<?php

namespace Curder\FilamentRichEditorSourceCode;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Curder\FilamentRichEditorSourceCode\Commands\FilamentRichEditorSourceCodeCommand;

class FilamentRichEditorSourceCodeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-rich-editor-source-code')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_filament_rich_editor_source_code_table')
            ->hasCommand(FilamentRichEditorSourceCodeCommand::class);
    }
}
