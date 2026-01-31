<?php

namespace Curder\FilamentRichEditorSourceCode;

use Curder\FilamentRichEditorSourceCode\Plugins\CustomRichContentPlugin;
use Curder\FilamentRichEditorSourceCode\Plugins\RichEditorSourceCodePlugin;
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
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Js::make(id: 'rich-content-plugins/source-code', path: __DIR__.'/../resources/dist/source-code.js')->loadedOnRequest(),
            Js::make(id: 'rich-content-plugins/custom', path: __DIR__.'/../resources/dist/custom.js')->loadedOnRequest(),
        ], 'curder/filament-rich-editor-source-code');

        // Register the plugin globally with RichEditor
        RichEditor::configureUsing(function (RichEditor $richEditor) {
            $richEditor->plugins([
                RichEditorSourceCodePlugin::make(),
                CustomRichContentPlugin::make(),
            ]);
        });
    }

    protected function getAssetPackageName(): string
    {
        return 'curder/filament-rich-editor-source-code';
    }
}
