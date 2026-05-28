<?php

it('has source-code dist file', function () {
    $path = __DIR__.'/../resources/dist/source-code.js';

    expect(file_exists($path))->toBeTrue();
    expect(filesize($path))->toBeGreaterThan(0);
});

it('has custom dist file', function () {
    $path = __DIR__.'/../resources/dist/custom.js';

    expect(file_exists($path))->toBeTrue();
    expect(filesize($path))->toBeGreaterThan(0);
});

it('has source-code source file', function () {
    $path = __DIR__.'/../resources/js/source-code.js';

    expect(file_exists($path))->toBeTrue();
    expect(filesize($path))->toBeGreaterThan(0);
});

it('has custom source file', function () {
    $path = __DIR__.'/../resources/js/custom.js';

    expect(file_exists($path))->toBeTrue();
    expect(filesize($path))->toBeGreaterThan(0);
});

it('source-code dist contains TipTap extension export', function () {
    $contents = file_get_contents(__DIR__.'/../resources/dist/source-code.js');

    // Should contain extension creation patterns
    expect($contents)->toContain('source-code');
});

it('custom dist contains div node definition', function () {
    $contents = file_get_contents(__DIR__.'/../resources/dist/custom.js');

    expect($contents)->toContain('div');
});

it('has all required language directories', function () {
    $langPath = __DIR__.'/../resources/lang';

    expect(is_dir($langPath.'/en'))->toBeTrue();
    expect(is_dir($langPath.'/zh_CN'))->toBeTrue();
    expect(is_dir($langPath.'/zh_TW'))->toBeTrue();
    expect(is_dir($langPath.'/zh_HK'))->toBeTrue();
});

it('all language files have the source key', function () {
    $locales = ['en', 'zh_CN', 'zh_TW', 'zh_HK'];

    foreach ($locales as $locale) {
        $file = __DIR__."/../resources/lang/{$locale}/editor.php";

        expect(file_exists($file))->toBeTrue();

        $translations = require $file;

        expect($translations)->toBeArray()->toHaveKey('source');
        expect($translations['source'])->toBeString()->not->toBeEmpty();
    }
});
