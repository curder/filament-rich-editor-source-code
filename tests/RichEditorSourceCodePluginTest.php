<?php

use Curder\FilamentRichEditorSourceCode\Plugins\RichEditorSourceCodePlugin;

it('can be instantiated via make()', function () {
    $plugin = RichEditorSourceCodePlugin::make();

    expect($plugin)->toBeInstanceOf(RichEditorSourceCodePlugin::class);
});

it('has the correct plugin id', function () {
    $plugin = RichEditorSourceCodePlugin::make();

    expect($plugin->getId())->toBe('source-code');
});

it('returns an empty array for TipTap PHP extensions', function () {
    $plugin = RichEditorSourceCodePlugin::make();

    expect($plugin->getTipTapPhpExtensions())->toBeArray()->toBeEmpty();
});

it('returns TipTap JS extensions with a valid script source', function () {
    $plugin = RichEditorSourceCodePlugin::make();

    $extensions = $plugin->getTipTapJsExtensions();

    expect($extensions)->toBeArray()->toHaveCount(1);
    expect($extensions[0])->toBeString()->not->toBeEmpty();
});

it('returns editor tools with source-code tool', function () {
    $plugin = RichEditorSourceCodePlugin::make();

    $tools = $plugin->getEditorTools();

    expect($tools)->toBeArray()->toHaveCount(1);
});

it('returns an empty array for editor actions', function () {
    $plugin = RichEditorSourceCodePlugin::make();

    expect($plugin->getEditorActions())->toBeArray()->toBeEmpty();
});
