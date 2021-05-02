<?php

use Illuminate\Database\Seeder;
use App\Model\App\General\Settings;

class AppSettingsInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
            'app_name' => 'sense',
        ]);
    }
}
