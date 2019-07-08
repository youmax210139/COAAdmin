<?php

namespace App\Console\Commands;

use App\Models\LanguageLine;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Storage;

class CreateLanguage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:language';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Language_lines Table if it does not exist and generate row by language_lines.json';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!Schema::connection('mysql_admin')->hasTable('language_lines')) {
            // 創建翻譯表
            Schema::connection('mysql_admin')->create('language_lines', function (Blueprint $table) {
                $table->increments('id');
                $table->string('group');
                $table->index('group');
                $table->string('key');
                $table->text('text');
                $table->unique(['group', 'key']);
                $table->timestamps();
            });
        }
        $languages = json_decode(Storage::disk('local')->get('language.json'), true);
        //產生資料
        foreach ($languages as $key => $text) {
            LanguageLine::on('mysql_admin')->updateOrCreate([
                'group' => 'custom',
                'key' => $key,
            ], [
                'text' => $text,
            ]);
        }
    }
}
