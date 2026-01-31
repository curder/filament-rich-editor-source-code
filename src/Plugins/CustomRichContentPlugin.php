<?php

namespace Curder\FilamentRichEditorSourceCode\Plugins;

use Filament\Support\Facades\FilamentAsset;
use Curder\FilamentRichEditorSourceCode\Nodes\EnableDiv;
use Filament\Forms\Components\RichEditor\Plugins\Contracts\RichContentPlugin;

class CustomRichContentPlugin implements RichContentPlugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipTapPhpExtensions(): array
    {
        return [
            app(EnableDiv::class),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getTipTapJsExtensions(): array
    {
        return [
            FilamentAsset::getScriptSrc('rich-content-plugins/custom', 'curder/filament-rich-editor-source-code'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getEditorTools(): array
    {
        return [
            //
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getEditorActions(): array
    {
        return [];
    }
}
