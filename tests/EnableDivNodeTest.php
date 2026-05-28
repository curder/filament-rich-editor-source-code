<?php

use Curder\FilamentRichEditorSourceCode\Nodes\EnableDiv;

it('has the correct node name', function () {
    expect(EnableDiv::$name)->toBe('div');
});

it('can be instantiated', function () {
    $node = app(EnableDiv::class);

    expect($node)->toBeInstanceOf(EnableDiv::class);
});

it('has default options with empty HTMLAttributes', function () {
    $node = app(EnableDiv::class);

    $options = $node->addOptions();

    expect($options)->toBeArray()
        ->toHaveKey('HTMLAttributes')
        ->and($options['HTMLAttributes'])->toBeArray()->toBeEmpty();
});

it('parses div HTML tag', function () {
    $node = app(EnableDiv::class);

    $parseRules = $node->parseHTML();

    expect($parseRules)->toBeArray()->toHaveCount(1);
    expect($parseRules[0])->toHaveKey('tag');
    expect($parseRules[0]['tag'])->toBe('div');
});

it('defines id and class attributes', function () {
    $node = app(EnableDiv::class);

    $attributes = $node->addAttributes();

    expect($attributes)->toBeArray()
        ->toHaveKey('id')
        ->toHaveKey('class');
});

it('has null defaults for id and class attributes', function () {
    $node = app(EnableDiv::class);

    $attributes = $node->addAttributes();

    expect($attributes['id']['default'])->toBeNull();
    expect($attributes['class']['default'])->toBeNull();
});

it('renders HTML as a div element', function () {
    $node = app(EnableDiv::class);

    $result = $node->renderHTML((object) [], []);

    expect($result)->toBeArray();
    expect($result[0])->toBe('div');
});

it('renders HTML with merged attributes', function () {
    $node = app(EnableDiv::class);

    $result = $node->renderHTML((object) [], ['class' => 'test-class']);

    expect($result)->toBeArray();
    expect($result[0])->toBe('div');
    // The second element contains merged attributes
    expect($result[1])->toBeArray()->toHaveKey('class');
    expect($result[1]['class'])->toBe('test-class');
});

it('uses zero as content placeholder in rendered HTML', function () {
    $node = app(EnableDiv::class);

    $result = $node->renderHTML((object) [], []);

    // The last element should be 0, indicating where child content goes
    expect(end($result))->toBe(0);
});
