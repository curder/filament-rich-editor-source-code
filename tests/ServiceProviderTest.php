<?php

use Curder\FilamentRichEditorSourceCode\FilamentRichEditorSourceCodeServiceProvider;

it('registers the service provider', function () {
    expect(app()->getProviders(FilamentRichEditorSourceCodeServiceProvider::class))
        ->toHaveCount(1);
});

it('has a valid package name', function () {
    $provider = app()->getProvider(FilamentRichEditorSourceCodeServiceProvider::class);

    expect($provider)->toBeInstanceOf(FilamentRichEditorSourceCodeServiceProvider::class);
});

it('registers translations', function () {
    $translation = trans('filament-rich-editor-source-code::editor.source');

    expect($translation)->toBe('HTML Source');
});

it('provides translations for zh_CN locale', function () {
    app()->setLocale('zh_CN');

    $translation = trans('filament-rich-editor-source-code::editor.source');

    expect($translation)->toBe('HTML源码');
});

it('provides translations for zh_TW locale', function () {
    app()->setLocale('zh_TW');

    $translation = trans('filament-rich-editor-source-code::editor.source');

    // Should not fall back to the key name
    expect($translation)->not->toBe('filament-rich-editor-source-code::editor.source');
});

it('provides translations for zh_HK locale', function () {
    app()->setLocale('zh_HK');

    $translation = trans('filament-rich-editor-source-code::editor.source');

    expect($translation)->not->toBe('filament-rich-editor-source-code::editor.source');
});
