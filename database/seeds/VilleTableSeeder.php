<?php

use Illuminate\Database\Seeder;

class VilleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data_secteurs=[
            ['secteur_id'=>1,'libelle'=>'Secteur CASA'],
            ['secteur_id'=>2,'libelle'=>'Secteur RABAT'],
            ['secteur_id'=>3,'libelle'=>'Secteur CENTRE'],
            ['secteur_id'=>4,'libelle'=>'Secteur ORIENTAL'],
            ['secteur_id'=>5,'libelle'=>'Secteur NORD'],
            ['secteur_id'=>6,'libelle'=>'Secteur MARRAKECH'],
            ['secteur_id'=>7,'libelle'=>'Secteur Agadir']];

        DB::table('secteurs')->insert($data_secteurs);

        $data_villes=[
            ['ville_id'=>1,'libelle' => 'CASABLANCA','secteur_id' => 1],
            ['ville_id'=>4,'libelle' => 'BENI MELLAL','secteur_id' => 1],
            ['ville_id'=>3,'libelle' => 'BERRECHID','secteur_id' => 1],
            ['ville_id'=>2,'libelle' => 'EL JADIDA','secteur_id' => 1],
            ['ville_id'=>5,'libelle' => 'KHOURIBGA','secteur_id' => 1],
            ['ville_id'=>6,'libelle' => 'MOHAMMEDIA','secteur_id' => 1],
            ['ville_id'=>7,'libelle' => 'SAFI','secteur_id' => 1],
            ['ville_id'=>8,'libelle' => 'BENSLIMANE','secteur_id' => 2],
            ['ville_id'=>9,'libelle' => 'SETTAT','secteur_id' => 1],
            ['ville_id'=>10,'libelle' => 'KENITRA','secteur_id' => 2],
            ['ville_id'=>11,'libelle' => 'KHEMISSET','secteur_id' => 2],
            ['ville_id'=>12,'libelle' => 'RABAT','secteur_id' => 2],
            ['ville_id'=>13,'libelle' => 'SALE','secteur_id' => 2],
            ['ville_id'=>14,'libelle' => 'TEMARA','secteur_id' => 2],
            ['ville_id'=>15,'libelle' => 'FES','secteur_id' => 3],
            ['ville_id'=>16,'libelle' => 'GUERCIF','secteur_id' => 3],
            ['ville_id'=>17,'libelle' => 'MEKNES','secteur_id' => 3],
            ['ville_id'=>18,'libelle' => 'TAZA','secteur_id' => 3],
            ['ville_id'=>19,'libelle' => 'BERKANE','secteur_id' => 4],
            ['ville_id'=>20,'libelle' => 'MIDAR','secteur_id' => 4],
            ['ville_id'=>21,'libelle' => 'NADOR','secteur_id' => 4],
            ['ville_id'=>22,'libelle' => 'OUJDA','secteur_id' => 4],
            ['ville_id'=>23,'libelle' => 'TAOURIRT','secteur_id' => 4],
            ['ville_id'=>24,'libelle' => 'LAKSAR LAKBIR','secteur_id' => 5],
            ['ville_id'=>25,'libelle' => 'LARACHE','secteur_id' => 5],
            ['ville_id'=>26,'libelle' => 'MEDIQ','secteur_id' => 5],
            ['ville_id'=>27,'libelle' => 'TANGER','secteur_id' => 5],
            ['ville_id'=>28,'libelle' => 'CHEFCHAOUEN','secteur_id' => 5],
            ['ville_id'=>29,'libelle' => 'Al Hoceima','secteur_id' => 5],
            ['ville_id'=>30,'libelle' => 'TETOUANE','secteur_id' => 5],
            ['ville_id'=>31,'libelle' => 'MARRAKECH','secteur_id' => 6],
            ['ville_id'=>45,'libelle' => 'El Kelâa des Sraghna','secteur_id' => 6],
            ['ville_id'=>46,'libelle' => 'Youssoufia','secteur_id' => 6],
            ['ville_id'=>32,'libelle' => 'AGADIR','secteur_id' => 7],
            ['ville_id'=>33,'libelle' => 'AIT MELLOUL','secteur_id' => 7],
            ['ville_id'=>34,'libelle' => 'INEZGANE','secteur_id' => 7],
            ['ville_id'=>35,'libelle' => 'LAAYOUNE','secteur_id' => 7],
            ['ville_id'=>36,'libelle' => 'OULED TAIMA','secteur_id' => 7],
            ['ville_id'=>37,'libelle' => 'TAROUDANT','secteur_id' => 7],
            ['ville_id'=>38,'libelle' => 'Guelmim','secteur_id' => 7],
            ['ville_id'=>39,'libelle' => 'ZAGORA','secteur_id' => 7],
            ['ville_id'=>40,'libelle' => 'OUARZAZATE','secteur_id' => 7],
            ['ville_id'=>41,'libelle' => 'TANTAN','secteur_id' => 7],
            ['ville_id'=>42,'libelle' => 'Essaouira','secteur_id' => 7],
            ['ville_id'=>43,'libelle' => 'SIDI IFNI','secteur_id' => 7],
            ['ville_id'=>44,'libelle' => 'TIZNIT','secteur_id' => 7],
            ['ville_id'=>47,'libelle' => 'SEFROU','secteur_id' => 3],
            ['ville_id'=>48,'libelle' => 'TATA','secteur_id' => 7],
            ['ville_id'=>49,'libelle' => 'Sidi Slimane','secteur_id' => 2],
            ['ville_id'=>50,'libelle' => 'Ouezzane','secteur_id' => 5],
        ];

        DB::table('villes')->insert($data_villes);
    }
}
