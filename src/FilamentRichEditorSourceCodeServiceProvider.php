<?php

namespace Curder\FilamentRichEditorSourceCode;

use Filament\Forms\Components\RichEditor;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Js::make(
                id: 'rich-content-plugins/source-code',
                path: __DIR__.'/../resources/dist/source-code.js'
            )->loadedOnRequest(),
        ], $this->getAssetPackageName());

        // Register the plugin globally with RichEditor
        RichEditor::configureUsing(function (RichEditor $richEditor) {
            $richEditor->plugins([
                RichEditorSourceCodePlugin::make(),
            ]);
        });
    }

    protected function getAssetPackageName(): string
    {
        return 'curder/filament-rich-editor-source-code';
    }
}
