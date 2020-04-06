<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data_role=[
            ['role_id'=>1,'libelle'=>'SUPADMIN'],
            ['role_id'=>2,'libelle'=>'ADMIN'],
            ['role_id'=>3,'libelle'=>'DSM'],
            ['role_id'=>4,'libelle'=>'KAM'],
            ['role_id'=>5,'libelle'=>'DM'],
            ['role_id'=>6,'libelle'=>'DPH'],
        ];

        DB::table('roles')->insert($data_role);

        DB::table('users')->insert([
            'ville_id' => 1,
            'nom' => 'SUPER',
            'prenom' => 'ADMIN',
            'title' => 'Mr',
            'email' => 'admin@crm.ma',
            'password' => Hash::make('admin123456'),
            'role_id' => 1,
        ]);
    }
}
