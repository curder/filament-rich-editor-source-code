<?php

namespace Curder\FilamentRichEditorSourceCode\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Curder\FilamentRichEditorSourceCode\FilamentRichEditorSourceCode
 */
class FilamentRichEditorSourceCode extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Curder\FilamentRichEditorSourceCode\FilamentRichEditorSourceCode::class;
    }
}
