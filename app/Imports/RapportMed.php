<?php

namespace App\Imports;

use App\Imports\Functions;
// use App\Medecin;
// use App\Produit;
// use App\Specialite;
use App\VisiteMedical;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
//use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RapportMed implements ToCollection, WithHeadingRow
{

    public function Collection(Collection $collection)
    {
        /*
         * i will use in this Test [ ID USER = 2 ] witch is EL MEHDI ID
         * */

         //******************  BEGIN MEDECIN NAME  ******************
            $GLOBALS['error_medecin'] = false;    
         //******************  END MEDECIN NAME  ******************

        //*****************  BEGIN CATCH LAST DATE  *****************
            //CATCH DATE OF LAST INSERTED VISITE AND CHANGE FORMAT
            $last_date_visite_DB = VisiteMedical::select('date_visite')
            ->where('user_id',2)
            ->whereIn('etat', ['Réalisé', 'Réalisé hors Plan'])
            ->groupBy('date_visite')
            ->orderBy('date_visite', 'desc')
            ->first();
        //*****************  END CATCH LAST DATE  *****************

            if(!empty($last_date_visite_DB)){
                //IMPORTANT !!! TO VERIFY IF THERE IS ANY DATA ON DATABASE
                //*****************  BEGIN CHANGE FORMAT  *****************
                    //CHANGE FORMAT TO DATE
                    $last_date_visite_DB = $last_date_visite_DB['date_visite']->format('Y-m-d');
                //*****************  BEGIN CHANGE FORMAT  *****************

                //*****************  BEGIN CATCH VISITES  *****************
                    //AFTER CATCH DATE OF LAST INSERTED VISITE
                    //WE IGNORE OTHER VISITES LESS THAN $last_date_visite_DB  ON COLLECTION
                    $visites = $collection->where('date_de_visite', '>',Date::PHPToExcel( $last_date_visite_DB ))
                    ->whereIn('planrealise', ['Réalisé', 'Réalisé hors Plan']);
                //*****************  END CATCH VISITES  *****************

                if ($visites->isEmpty()) {
                    //IF THERE IS NO VISITE TO ADD TO DATABASE SHOW ALERT MESSAGE !
                    print_r(" <b><span style='color:#efe400;'>Ooops</span></b> : <i>NOTHING TO ADD TO DATABASE ! VERIFY YOUR VISIT DATE</i>");
                }
            }else{
                //*****************  BEGIN CATCH VISITES [REALISE / REALISE HORS PLAN]  *****************
                $visites = $collection->whereIn('planrealise', ['Réalisé', 'Réalisé hors Plan']);
                //*****************  END CATCH VISITES [REALISE / REALISE HORS PLAN] *****************
            }

            $visites->each(function ($item, $count) {
                $count++; 
                //*****************  BEGIN MEDECIN  *****************
                    //SEARCH FOR NAME OF MEDECIN AND RETURN THE ID
                    //IGNORE VISIT AFTER VERIFING ID OF MEDECINE IF DOES NOT EXISTS AND RETURNS NULL VALUE ...
                    //SHOW MSG ALERT TO VERIFY COLUMN [nom prenom, nom, prenom]
                    $medecin_id = Functions::search_medecin_id($item['nom_prenom']);
                    if (empty($medecin_id)) {
                        $date = NULL;
                        if (gettype($item['date_de_visite']) == 'integer') {
                            $date = Date::excelToDateTimeObject($item['date_de_visite'])->format('Y-m-d');
                        }else{
                            $date = $item['date_de_visite'];
                        }
                        print_r("<br><b><span style='color:#efe400;'>Ooops</b></span> : <i>VERIFIER CETTE VISITE : <br>
                            Date : ".$date.
                        "<br>NOM PRENOM : ".($item['nom_prenom'] == "" ? "NULL" : $item['nom_prenom']).
                        "<br>NOMBRE DE LIGNE (SOUS EXCEL) : ".($count+1).
                        "<br><span style='color:Red;'><b><u>Important</u></b></span> : Verifier les colonnes [ nom prenom, nom, prenom ] dans [ Liste Med ] et [ nom prenom ] dans [ Rapport Med ] du fichier Excel !</i><br><br>");
                        //TRUE MEANS CONTINUE TO THE NEXT ELEMET ON FOREACH TABLE
                        $GLOBALS['error_medecin']=true;
                        return true;
                    }
                //*****************  END MEDECIN  *****************
            });

            if ($GLOBALS['error_medecin']) {
                $visites = false;
            }


                if(!empty($visites)){
                    //TO VERIFY IF THERE IS ANY LINE OF VISITE TO ADD INTO DATABASE
                    $visites->each(function ($item) {
                        //*****************  CHANGE IT INTO INFO OF AUTH USER [AFTER]  *****************
                            $ID_USER = 2;
                            $created_by="EL MEHDI AIT FAKIR";
                        //*****************  END  *****************

                        //*****************  BEGIN MEDECIN  *****************
                            //SEARCH FOR NAME OF MEDECIN AND RETURN THE ID
                            $medecin_id = Functions::search_medecin_id($item['nom_prenom']);
                        //*****************  END MEDECIN  *****************
     
                        //*****************  BEGIN ETAT  *****************
                            //PLAN - REALISE - REALISE HORS PLAN
                            $etat = $item['planrealise'];
                        //*****************  END ETAT  *****************

                        //*****************  BEGIN DATE  *****************
                            //CHANGE FORMAT OF DATE
                            $date_visite = Date::excelToDateTimeObject($item['date_de_visite'])->format('Y-m-d');
                        //*****************  END DATE  *****************

                        //*****************  BEGIN VISITE  *****************
                            //CREATE NEW VISITE AND RETURN THE ID
                            $last_visite_id = Functions::create_visite($ID_USER, $medecin_id, $etat, $date_visite, $created_by);
                        //*****************  END VISITE  *****************

                        //*****************  BEGIN DECLARATION  *****************
                        $produit_id = NULL;
                        $feedback_id = NULL;
                        $nbr_ech = 0;
                        //*****************  END DECLARATION  *****************

                        // *****************  BEGIN PRODUIT 01  *****************
                            //VERIFY [NAME_PRODUCT, FEEDBACK_PRODUCT, NBR_ECH] AND INSERT THEM ON DATABASE
                            if (!empty($item['p1_presente'])){

                                $produit_id = Functions::search_product_id($item['p1_presente']);
                                if(!empty($item['p1_feedback'])){
                                    $feedback_id = Functions::create_feedback($item['p1_feedback']);
                                }
                                if(!empty($item['p1_ech'])){
                                    $nbr_ech = $item['p1_ech'];
                                }
                                Functions::create_visite_med_product($last_visite_id, $produit_id, $feedback_id , $nbr_ech);
                            }
                        // *****************  END PRODUIT 01  *****************

                        //*****************  BEGIN DECLARATION  *****************
                        $produit_id = NULL;
                        $feedback_id = NULL;
                        $nbr_ech = 0;
                        //*****************  END DECLARATION  *****************

                        // *****************  BEGIN PRODUIT 02  *****************
                            //VERIFY [NAME_PRODUCT, FEEDBACK_PRODUCT, NBR_ECH] AND INSERT THEM ON DATABASE
                            if (!empty($item['p2_presente'])){

                                $produit_id = Functions::search_product_id($item['p2_presente']);
                                if(!empty($item['p2_feedback'])){
                                    $feedback_id = Functions::create_feedback($item['p2_feedback']);
                                }
                                if(!empty($item['p2_ech'])){
                                    $nbr_ech = $item['p2_ech'];
                                }
                                Functions::create_visite_med_product($last_visite_id, $produit_id, $feedback_id , $nbr_ech);
                            }
                        // *****************  END PRODUIT 02  *****************

                        //*****************  BEGIN DECLARATION  *****************
                        $produit_id = NULL;
                        $feedback_id = NULL;
                        $nbr_ech = 0;
                        //*****************  END DECLARATION  *****************

                        // *****************  BEGIN PRODUIT 03  *****************
                            //VERIFY [NAME_PRODUCT, FEEDBACK_PRODUCT, NBR_ECH] AND INSERT THEM ON DATABASE
                            if (!empty($item['p3_presente'])){

                                $produit_id = Functions::search_product_id($item['p3_presente']);
                                if(!empty($item['p3_feedback'])){
                                    $feedback_id = Functions::create_feedback($item['p3_feedback']);
                                }
                                if(!empty($item['p3_ech'])){
                                    $nbr_ech = $item['p3_ech'];
                                }
                                Functions::create_visite_med_product($last_visite_id, $produit_id, $feedback_id , $nbr_ech);
                            }
                        // *****************  END PRODUIT 03  *****************

                        //*****************  BEGIN DECLARATION  *****************
                        $produit_id = NULL;
                        $feedback_id = NULL;
                        $nbr_ech = 0;
                        //*****************  END DECLARATION  *****************

                        // *****************  BEGIN PRODUIT 04  *****************
                            //VERIFY [NAME_PRODUCT, FEEDBACK_PRODUCT, NBR_ECH] AND INSERT THEM ON DATABASE
                            if (!empty($item['p4_presente'])){

                                $produit_id = Functions::search_product_id($item['p4_presente']);
                                if(!empty($item['p4_feedback'])){
                                    $feedback_id = Functions::create_feedback($item['p4_feedback']);
                                }
                                if(!empty($item['p4_ech'])){
                                    $nbr_ech = $item['p4_ech'];
                                }
                                Functions::create_visite_med_product($last_visite_id, $produit_id, $feedback_id , $nbr_ech);
                            }
                        // *****************  END PRODUIT 04  *****************

                        //*****************  BEGIN DECLARATION  *****************
                        $produit_id = NULL;
                        $feedback_id = NULL;
                        $nbr_ech = 0;
                        //*****************  END DECLARATION  *****************

                        // *****************  BEGIN PRODUIT 05  *****************
                            //VERIFY [NAME_PRODUCT, FEEDBACK_PRODUCT, NBR_ECH] AND INSERT THEM ON DATABASE
                            if (!empty($item['p5_presente'])){

                                $produit_id = Functions::search_product_id($item['p5_presente']);
                                if(!empty($item['p5_feedback'])){
                                    $feedback_id = Functions::create_feedback($item['p5_feedback']);
                                }
                                if(!empty($item['p5_ech'])){
                                    $nbr_ech = $item['p5_ech'];
                                }
                                Functions::create_visite_med_product($last_visite_id, $produit_id, $feedback_id , $nbr_ech);
                            }
                        // *****************  END PRODUIT 05  *****************

                   
                    });

                }else{
                    print_r("<br><b><span style='color:#efe400;'>Ooops</span></b> : <i>THERE IS NO LINE OF VISITE TO ADD, VERIFY DATES</i><br>");
                }

        // echo "<br> ############## RapportMed ############ <br>";
        // var_dump($collection);
        // echo "<br> ########################## <br>";


    }


}
