<?php

namespace Curder\FilamentRichEditorSourceCode\Facades;

use Curder\FilamentRichEditorSourceCode\RichEditorSourceCodePlugin;
use Illuminate\Support\Facades\Facade;

/**
 * @see RichEditorSourceCodePlugin
 */
class FilamentRichEditorSourceCode extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RichEditorSourceCodePlugin::class;
    }
}
