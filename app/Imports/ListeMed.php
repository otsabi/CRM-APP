<?php

namespace App\Imports;

use App\Medecin;
use App\Imports\Functions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;


class ListeMed implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{

    public function Collection(Collection $collection)
    {
        
        //******************  BEGIN MEDECIN NAME  ******************
            $GLOBALS['error_non_prenom'] = false;    
        //******************  END MEDECIN NAME  ******************

        //******************  BEGIN MEDECIN NAME  ******************
            //SELECT ALL MEDECIN NAME FROM DB
            $medecins_db = Medecin::select(
                DB::raw('UPPER(CONCAT(nom," ",prenom)) as nom_prenom')
            )
            ->pluck('nom_prenom');
        //******************  END MEDECIN NAME  ******************
    
        //******************  BEGIN FILTER MEDECIN NAME  ******************
            //DELETE ANY SPACE ON THE END OF [ nom prenom ] USING RTRIM FUNCTION
            //FILTER JUST MEDECIN NAME WHITCH DOES NOT ...
            //... EXISTS ON DB FROM EXCEL FILE
            //IGNORE COLUMN [ nom prenom ] IF IT HAS NULL VALUE
            
            $collection = $collection->where('nom_prenom','!=', NULL);
                                     //->where('nom','!=', NULL)
                                     //->where('prenom','!=', NULL);

            $medecins_excel = $collection->map(function ($item, $count) {
                $count++;   
                $item['nom'] = mb_strtoupper(rtrim($item['nom']));
                $item['prenom'] = mb_strtoupper(rtrim($item['prenom']));
                $nom_complet = $item['nom'].' '.$item['prenom'];
                if (strcasecmp($item['nom_prenom'], $nom_complet) != 0) {
                    print_r("<br><b><span style='color:#efe400;'>Ooops</b></span> : <i>VERIFIER CETTE LIGNE DANS LA LISTE MEDECINE : <br>
                                    NOM PRENOM : ".($item['nom_prenom'] == "" ? "NULL" : $item['nom_prenom']).
                                "<br>NOMBRE DE LIGNE (SOUS EXCEL) : ".($count+1).
                                "<br><span style='color:Red;'><b><u>Important</u></b></span> : Verifier les colonnes [ nom prenom, nom, prenom ] dans [ Liste Med ] et [ nom prenom ] dans [ Rapport Med ] du fichier Excel !</i><br><br>");
                                $GLOBALS['error_non_prenom'] = true;            
                }
            });

            if ($GLOBALS['error_non_prenom']) {
                $medecins_excel=false;
            }else{
                $medecins_excel = $collection->whereNotIn('nom_prenom', $medecins_db)
                                         ->whereNotIn('nom_prenom', " ");
            }

        //******************  END FILTER MEDECIN NAME  ******************

        if (!empty($medecins_excel)) {
            
            //ADD MEDECIN, IF THERE ID ANY NEW MEDECIN DOES NOT EXISTS ON DB
            $medecins_excel->each(function ($item) {

                //******************  CHANGE IT INTO INFO OF AUTH USER [AFTER]  ******************
                    $ID_USER = 2;
                    $created_by="EL MEHDI AIT FAKIR";
                //******************  END  ******************


                //******************  BEGIN INFO OF MEDECIN  ******************
                    $nom = mb_strtoupper($item['nom']);
                    $prenom = mb_strtoupper($item['prenom']);
                    $adresse = $item['adresse'];
                    $tel = $item['tel'];
                    $etablissement = mb_strtoupper($item["etablissement"]);
                    $potentiel = $item['potentiel'];        
                    $zone = mb_strtoupper($item["zone_sous_secteur"]);
                //******************  END INFO OF MEDECIN ******************
            
                //******************  BEGIN RETURN ID OF VILLE  ******************
                    $ville_id = Functions::search_ville(mb_strtoupper($item["ville"]));
                //******************  END RETURN ID OF VILLE  ******************
            
                //******************  BEGIN RETURN ID OF SPECIALISTE  ******************
                    $specialite_id = Functions::search_specialite(mb_strtoupper($item["specialite"]));
                //******************  END RETURN ID OF SPECIALISTE  ******************
            

            Functions::create_medecin($nom, $prenom, $adresse, $tel, $etablissement, $potentiel, $zone, $ville_id, $ID_USER, $specialite_id, $created_by);
    
            });

        }
        
        // else{
        //     //print_r("<br><b>Ooops :</b> <i>THERE ISN'T ANY NEW MEDICINE TO ADD !</i><br>");
        //     print_r("<br><b>Ooops :</b> <i>LISTE MED EST A JOUR !</i><br>");
        // }

        // echo "<br> ############# ListeMed ############# <br>";
        // var_dump($collection);
        // echo "<br> ########################## <br>";

    }

}
