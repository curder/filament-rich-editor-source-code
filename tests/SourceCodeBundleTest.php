<?php

it('ships a source-code TipTap extension that exposes active state via editor.isActive()', function () {
    $bundlePath = __DIR__.'/../resources/dist/source-code.js';

    expect(file_exists($bundlePath))->toBeTrue();

    $contents = file_get_contents($bundlePath);

    expect($contents)->toBeString()->not->toBeEmpty();

    // Filament toolbar uses: $getEditor()?.isActive('source-code', []) to apply fi-active.
    // Our extension must override isActive so it reflects source-mode state.
    expect($contents)->toContain('this.editor.isActive');
    expect($contents)->toContain('i===this.name');
    expect($contents)->toContain('this.editor.storage[this.name]?.isSourceMode');
});

it('disables and restores other toolbar buttons while in source mode (bundle contract)', function () {
    $bundlePath = __DIR__.'/../resources/dist/source-code.js';

    expect(file_exists($bundlePath))->toBeTrue();

    $contents = file_get_contents($bundlePath);

    expect($contents)->toBeString()->not->toBeEmpty();

    // Contract: we locate Filament toolbar + buttons and disable everything except the source button.
    expect($contents)->toContain('.fi-fo-rich-editor-toolbar');
    expect($contents)->toContain('button.fi-fo-rich-editor-tool');
    expect($contents)->toContain('data-tiptap-menu-item-name="source-code"');

    // Contract: accessibility + keyboard nav
    expect($contents)->toContain('aria-disabled');
    expect($contents)->toContain('tabindex');

    // Contract: snapshot & restore previous states
    expect($contents)->toContain('toolbarButtonsSnapshot');
    expect($contents)->toContain('new Map');
});
