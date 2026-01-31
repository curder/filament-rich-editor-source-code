<?php

namespace Curder\FilamentRichEditorSourceCode\Commands;

use Illuminate\Console\Command;

class FilamentRichEditorSourceCodeCommand extends Command
{
    public $signature = 'filament-rich-editor-source-code';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
