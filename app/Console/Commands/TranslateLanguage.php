<?php

namespace App\Console\Commands;

use App\Servicies\AitranslationService;
use Illuminate\Console\Command;

class TranslateLanguage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:lang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(AitranslationService $ai)
    {
        $content= include lang_path('en/message.php');

        $translated=$ai->translate($content,'Arabic');

        $file="<?php\n\nreturn " . var_export($translated,true) .";\n";

        file_put_contents(
            lang_path('ar/message.php'),
            $file
        );

        $this->info('Translation completed');
    }
}
