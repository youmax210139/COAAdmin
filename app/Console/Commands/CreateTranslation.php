<?php

namespace App\Console\Commands;

use App\Models\Translation;
use Illuminate\Console\Command;
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

    protected $table = [
        'product' => [
            'product_name',
            'farm',
        ],
        'task_log' => [
            'task',
            'location',
            'tool',
            'tool_type',
        ],
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

        Translation::on('mysql_admin')->truncate();
        foreach ($this->table as $table => $columns) {
            $model = studly_case($table);
            $model = app("App\Models\\$model")->get();
            foreach ($columns as $column) {
                foreach ($model as $row) {
                    $this->insertRow($table, $column, $row->getKey(), $row->$column);
                }
            }
        }
    }

    protected function insertRow($table, $column, $foreign_key, $value)
    {
        $locales = [
            'zhtw' => $value,
            'en' => $this->translations[$value], //en
        ];
        foreach ($locales as $locale => $value) {
            Translation::on('mysql_admin')->create([
                'table_name' => $table,
                'column_name' => $column,
                'foreign_key' => $foreign_key,
                'locale' => $locale,
                'value' => $value,
            ]);
        }

    }
}
