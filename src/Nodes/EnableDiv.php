<?php

namespace Curder\FilamentRichEditorSourceCode\Nodes;

use Tiptap\Core\Node;
use Tiptap\Utils\HTML;

class EnableDiv extends Node
{
    public static $name = 'div';

    public function addOptions(): array
    {
        return [
            'HTMLAttributes' => [],
        ];
    }

    public function parseHTML(): array
    {
        return [
            [
                'tag' => 'div',
            ],
        ];
    }

    public function addAttributes(): array
    {
        return [
            'id' => [
                'default' => null,
                'parseHTML' => fn ($DOMNode) => $DOMNode->getAttribute('id') ?: null,
                'renderHTML' => fn ($attributes) => isset($attributes->id) ? ['id' => $attributes->id] : [],
            ],
            'class' => [
                'default' => null,
                'parseHTML' => fn ($DOMNode) => $DOMNode->getAttribute('class') ?: null,
                'renderHTML' => fn ($attributes) => isset($attributes->class) ? ['class' => $attributes->class] : [],
            ],
        ];
    }

    public function renderHTML($node, $HTMLAttributes = []): array
    {
        return ['div', HTML::mergeAttributes($this->options['HTMLAttributes'], $HTMLAttributes), 0];
    }
}
