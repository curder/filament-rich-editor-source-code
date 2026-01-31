<?php

namespace Curder\FilamentRichEditorSourceCode\Plugins;

use Filament\Forms\Components\RichEditor\Plugins\Contracts\RichContentPlugin;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Icons\Heroicon;

class RichEditorSourceCodePlugin implements RichContentPlugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'source-code';
    }

    public function getTipTapPhpExtensions(): array
    {
        return [];
    }

    public function getTipTapJsExtensions(): array
    {
        return [
            FilamentAsset::getScriptSrc('rich-content-plugins/source-code', 'curder/filament-rich-editor-source-code'),
        ];
    }

    public function getEditorTools(): array
    {
        return [
            RichEditorTool::make('source-code')
                ->icon(Heroicon::OutlinedCodeBracket)
                ->label(__('filament-rich-editor-source-code::editor.source'))
                ->extraAttributes(['data-tiptap-menu-item-name' => 'source-code'])
                ->jsHandler(<<<'JS'
                    $getEditor()?.chain().focus().toggleSourceCode().run()
                JS),
        ];
    }

    public function getEditorActions(): array
    {
        return [];
    }
}
