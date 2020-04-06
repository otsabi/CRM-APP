<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('produits')->truncate();
        DB::table('secteurs')->truncate();
        DB::table('villes')->truncate();
        DB::table('gammes')->truncate();
        DB::table('specialites')->truncate();
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $this->call([
            ProduitsTableSeeder::class,
            VilleTableSeeder::class,
            SpecialiteTableSeeder::class,
            UsersTableSeeder::class,
        ]);

    }
}
