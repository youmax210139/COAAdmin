<?php

namespace App\Console\Commands;

use App\Models\Translation;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Storage;

class CreateTranslation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:translation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Translate Table if it does not exist and generate row by table attribute and translation json';

    protected $translations;

    protected $tables = [
        'product',
        'task_log',
        'language_line',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->translations = json_decode(Storage::disk('local')->get('translation.json'), true);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!Schema::connection('mysql_admin')->hasTable('translations')) {
            // 創建翻譯表
            Schema::connection('mysql_admin')->create('translations', function (Blueprint $table) {
                $table->increments('id');
                $table->string('table_name', 50);
                $table->string('column_name', 50);
                $table->integer('foreign_key')->unsigned();
                $table->string('locale', 10);
                $table->text('value')->comment('翻譯');
                $table->text('default')->comment('原始值');
                $table->unique(['table_name', 'column_name', 'foreign_key', 'locale']);
                $table->index(['table_name', 'column_name', 'locale', 'foreign_key']);
                $table->timestamps();
            });
        }

        //產生資料
        foreach ($this->tables as $table) {
            $model = studly_case($table);
            $model = app("App\Models\\$model");
            foreach ($model->getTranslatableAttributes() as $column) {
                foreach ($model->get() as $row) {
                    $this->updateOrCreateRow($model->getTable(), $column, $row->getKey(), $row->$column);
                }
            }
        }
    }

    protected function updateOrCreateRow($table, $column, $foreign_key, $value)
    {
        $locales = [
            'en' => $this->translations[$value]??'',
        ];
        foreach ($locales as $locale => $v) {
            Translation::on('mysql_admin')->updateOrCreate([
                'table_name' => $table,
                'column_name' => $column,
                'foreign_key' => $foreign_key,
            ], [
                'locale' => $locale,
                'value' => $v,
                'default' => $value,
            ]);
        }
    }
}
