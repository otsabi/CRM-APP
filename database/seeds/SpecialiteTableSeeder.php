<?php

use Illuminate\Database\Seeder;

class SpecialiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data_gammes=[
            ['gamme_id'=>1,'libelle'=>'G'],
            ['gamme_id'=>2,'libelle'=>'R'],
            ['gamme_id'=>3,'libelle'=>'D']]
        ;
        DB::table('gammes')->insert($data_gammes);

        $data_specialites=[
            ['gamme_id' => 2,'code' => 'URG','libelle' => 'médecine d\'urgence'],
            ['gamme_id' => 2,'code' => 'TRAUM','libelle' => 'Traumatologie'],
            ['gamme_id' => 2,'code' => 'RHUM','libelle' => 'Rhumatologie'],
            ['gamme_id' => 2,'code' => 'PHYSICIEN','libelle' => 'Physique médicale'],
            ['gamme_id' => 2,'code' => 'NEURO CHIR','libelle' => 'Neurochirurgie'],
            ['gamme_id' => 2,'code' => 'NEURO','libelle' => 'Neurologie'],
            ['gamme_id' => 2,'code' => 'INTER','libelle' => 'Médecine interne'],
            ['gamme_id' => 3,'code' => 'DERMATO','libelle' => 'Dermatologie'],
            ['gamme_id' => 3,'code' => 'PLAST','libelle' => 'Chirurgie plastique'],
            ['gamme_id' => 1,'code' => 'ANES','libelle' => 'Anesthésie-réanimation'],
            ['gamme_id' => 1,'code' => 'URO','libelle' => 'Urologie'],
            ['gamme_id' => 1,'code' => 'SAGE-FEMME','libelle' => 'SAGE-FEMME'],
            ['gamme_id' => 1,'code' => 'PEDIATRE','libelle' => 'Pédiatrie'],
            ['gamme_id' => 1,'code' => 'ONCO','libelle' => 'Oncologie'],
            ['gamme_id' => 1,'code' => 'NUTRI','libelle' => 'Nutritionniste ou Diététicien'],
            ['gamme_id' => 1,'code' => 'NEPHRO','libelle' => 'Néphrologie'],
            ['gamme_id' => 1,'code' => 'HEMATO','libelle' => 'Hématologie'],
            ['gamme_id' => 1,'code' => 'GYNECO','libelle' => 'Gynécologie'],
            ['gamme_id' => 1,'code' => 'GENERALISTE','libelle' => 'GENERALISTE'],
            ['gamme_id' => 1,'code' => 'GASTRO','libelle' => 'Gastro-entérologie'],
            ['gamme_id' => 1,'code' => 'ENDOCRINO','libelle' => 'Endocrinologie'],
            ['gamme_id' => 1,'code' => 'CARDIO','libelle' => 'Cardiologie'],
            ['gamme_id' => 2,'code' => 'CHIRU','libelle' => 'Chirurgie générale'],
            ['gamme_id' => 1,'code' => 'Autre','libelle' => 'Autre spécialité']];

        DB::table('specialites')->insert($data_specialites);
    }
}
