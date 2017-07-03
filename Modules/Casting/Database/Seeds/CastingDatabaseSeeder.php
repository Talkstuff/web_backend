<?php

namespace Modules\Casting\Database\Seeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Casting\Models\CastCategory;

class CastingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("SET foreign_key_checks=0");
        Model::unguard();

        // todo:: seed categories
        CastCategory::truncate();
        CastCategory::insert([
            [
                'name' => 'Mothers'
            ],
            [
                'name' => 'Mother-In-Law'
            ],
            [
                'name' => 'Pediatrician'
            ],
            [
                'name' => 'Child'
            ]
        ]);

        \DB::statement("SET foreign_key_checks=1");

    }
}
