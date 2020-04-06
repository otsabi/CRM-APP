<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use App\Feedback;
use App\Medecin;
use App\Produit;
use App\VisiteMedical;
use App\VmedProduit;
use App\Specialite;
use App\Ville;

class Functions
{
    static public function search_medecin_id($value){
        /*
         * 1- catche ID of product
         * 2- insert product into table visite_med_produit
         */
        $medecin = Medecin::select(
            DB::raw('UPPER(CONCAT(nom," ",prenom)) as nom_prenom, medecin_id')
        )
         ->pluck('medecin_id', 'nom_prenom');

        $medecin = $medecin->get(strtoupper($value));

        if (!empty($medecin)){
            return $medecin;
        }

    }

    static public function create_visite($user_id, $medecin_id, $etat, $date_visite, $created_by){
        /*
         * 1- insert new visite
         * 2- return last id of visite
         */

            $new_visite = new VisiteMedical();
            $new_visite->user_id=$user_id;
            $new_visite->medecin_id=$medecin_id;
            $new_visite->etat=$etat;
            $new_visite->date_visite=$date_visite;
            $new_visite->created_by=$created_by;
            $new_visite->save();

            if ($new_visite){
                return $new_visite->visitemed_id;
            }

    }

    static public function search_product_id($code_produit){
        /*
         * 1- catche ID of product
         * 2- insert product into table visite_med_produit
         */
        $produit = Produit::where("code_produit",$code_produit)->first();
        if ($produit){
            return $produit->produit_id;
        }
    }

    static public function create_feedback($feedback){
        /*
         * 0- verify if exist
         * 1- [ insert new Feedback if not exist ]
         * 2- return last id of Feedback
         */

        $feedback_exist = Feedback::where('libelle', $feedback)->first();
        if($feedback_exist){
            return $feedback_exist->feedback_id;
        }else{
            $new_feedback = new Feedback();
            $new_feedback->libelle = $feedback;
            $new_feedback->save();

            if ($new_feedback){
                return $new_feedback->feedback_id;
            }
        }

    }

    static public function create_visite_med_product($visite_id, $produit_id, $feedback_id , $nbr_ech){
        /*
         * 1- catche ID of product,feedback,number_ech
         * 2- insert into table visite_med_produit
         */
        $new_visite_produit = new VmedProduit();
        $new_visite_produit->visitemed_id=$visite_id;
        $new_visite_produit->produit_id=$produit_id;
        $new_visite_produit->feedback_id=$feedback_id;
        $new_visite_produit->nbr_ech=$nbr_ech;
        $new_visite_produit->save();
    }

    static public function create_medecin($nom, $prenom, $adresse, $tel, $etablissement, $potentiel, $zone, $ville_id, $user_id, $specialite_id, $created_by){
        /*
         * 1- catche NAME of MEDECIN, AND ALL INFOs
         * 2- insert into table medecins
         */
        $new_medecin = new Medecin();
        $new_medecin->nom = $nom;
        $new_medecin->prenom = $prenom;
        $new_medecin->adresse = $adresse;
        $new_medecin->tel = $tel;
        $new_medecin->etablissement = $etablissement;
        $new_medecin->potentiel = $potentiel;
        $new_medecin->zone_med = $zone;
        $new_medecin->ville_id = $ville_id;
        $new_medecin->user_id = $user_id;
        $new_medecin->specialite_id = $specialite_id;
        $new_medecin->created_by = $created_by;

        //var_dump($new_medecin);
        $new_medecin->save();
    }

    static public function search_ville($value){
        /*
         * 1- catche NAME of VILLE
         * 2- return ID of VILLE
         */
        $ville = Ville::where("libelle",strtoupper($value))->first();
        if ($ville){
            return $ville->ville_id;
        }
    }

    static public function search_specialite($value){
        /*
         * 1- catche NAME of specialite
         * 2- return ID of specialite
         */
        $specialite = Specialite::where("code",strtoupper($value))->first();
        if ($specialite){
            return $specialite->specialite_id;
        }
    }


}
