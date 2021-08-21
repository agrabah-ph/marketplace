<?php

namespace App\Console\Commands;

use App\Settings;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddSettingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:add {name} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add setting {name} {value}';

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
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $value = $this->argument('value');

        $settings = Settings::firstOrNew();
        $settings->name = $name;
        $settings->display_name = $name;
        $settings->value = $value;
        $settings->is_active = 1;
        $settings->save();

        $this->line("Settings Added");
    }
}
