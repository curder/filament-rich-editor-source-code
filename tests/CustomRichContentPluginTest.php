<?php

use Curder\FilamentRichEditorSourceCode\Plugins\CustomRichContentPlugin;
use Curder\FilamentRichEditorSourceCode\Nodes\EnableDiv;

it('can be instantiated via make()', function () {
    $plugin = CustomRichContentPlugin::make();

    expect($plugin)->toBeInstanceOf(CustomRichContentPlugin::class);
});

it('returns TipTap PHP extensions with EnableDiv node', function () {
    $plugin = CustomRichContentPlugin::make();

    $extensions = $plugin->getTipTapPhpExtensions();

    expect($extensions)->toBeArray()->toHaveCount(1);
    expect($extensions[0])->toBeInstanceOf(EnableDiv::class);
});

it('returns TipTap JS extensions with a valid script source', function () {
    $plugin = CustomRichContentPlugin::make();

    $extensions = $plugin->getTipTapJsExtensions();

    expect($extensions)->toBeArray()->toHaveCount(1);
    expect($extensions[0])->toBeString()->not->toBeEmpty();
});

it('returns an empty array for editor tools', function () {
    $plugin = CustomRichContentPlugin::make();

    expect($plugin->getEditorTools())->toBeArray()->toBeEmpty();
});

it('returns an empty array for editor actions', function () {
    $plugin = CustomRichContentPlugin::make();

    expect($plugin->getEditorActions())->toBeArray()->toBeEmpty();
});
