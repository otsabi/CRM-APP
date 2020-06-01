<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;
use App\RapportMed;
use App\RapportPh;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RapportMedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:SUPADMIN|ADMIN');
    }


    public function index(){
        return view('import.rapportMed.index');
    }

    public function delegue_from_name_file($name_file, $DMs){

                foreach($DMs as $DM){
                    $contains = Str::contains($name_file, [Str::lower($DM), Str::upper($DM)]);
                    if($contains == true){
                        return $DM;
                        break;
                                        }

                                    }

        return $contains;

    }


    public function import(Request $request){
                set_time_limit(500);

                //intialise an array of DM with their ID

                $DMs = array(   'ELOUADEH',
                                'IDDER',
                                'NABIL BISTFALEN',
                                'MOHAMED LAAMRAOUI',
                                'BADRE BENJELLOUN',
                                'AMINE EL MOUTAOUAKKIL ALAOUI',
                                'GHIZLANE EL OUADEH',
                                'MOHAMMED BOUHNINA MARNISSI',
                                'TARIK FAHSI',
                                'FIRDAOUSSE BELARABI',
                                'NAOUFEL BOURHIME',
                                'KARIMA BENHLIMA',
                                'KARIM BERRADY',
                                'HASSAN BELAHCEN',
                                'HICHAM EL HANAFI',
                                'MOSTAFA GHOUNDAL',
                                'NADA CHAFAI',
                                'MUSTAPHA HASNAOUI',
                                'MHAMED BOUHMADI',
                                'MOHAMED EL OUADEH',
                                'RACHID CHAMI',
                                'IDDER HAMDANI',
                                'FOUAD BOUZIYANE',
                                'ADIL SENHAJI',
                                'NAJIB SKALLI',
                                'RAJA KABBAJ',
                                'MOHAMED BOURRAGAT',
                                'TAREK BAJJOU',
                                'SALIM BOUHLAL',
                                'IMANE BOUJEDDAYINE',
                                'MOUNA CHARRADI',
                                'HASSAN IAJIB',
                                'HANANE DLIMI',
                                'ABDERRAHMANE EL BYARI',
                                'ZAKARIA TEMSAMANI',
                                'HICHAM EL MOUSTAKHIB');



                        $files = $request->file('import_file');

                        if($request->hasFile('import_file'))
                        {
                            foreach ($files as $file)
                            {

                                //THIS FIRST IS FOR LARAVEL-EXCEL PACKAGE
                                //Excel::import(new FileImport, $file);

                                //store original name of file.
                                //$GLOBALS["original_name"] = $file->getClientOriginalName();

                                $GLOBALS["file_name"]= $file->getClientOriginalName();


                                    $GLOBALS["Délégué"] = $this->delegue_from_name_file($file->getClientOriginalName(), $DMs);

                                    if($GLOBALS["Délégué"] != FALSE){

                                        (new FastExcel)->sheet(3)->import($file, function ($line)
                                        {

                                            if ( !empty($line["Nom Prenom"]) && $line["Nom Prenom"] != 'Nom Prenom' && ($line["Plan/Réalisé"] == "Réalisé" || $line["Plan/Réalisé"] == "Réalisé hors Plan")  ) {

                                                    if(gettype($line["Montant Inv Précédents"]) == 'integer' && $line["Montant Inv Précédents"] == 0 ){
                                                        $line["Montant Inv Précédents"] = NULL;
                                                    }elseif(gettype($line["Montant Inv Précédents"]) == 'string'){
                                                        $line["Montant Inv Précédents"] = NULL;
                                                    }
                                                    if (empty($line["P1 Ech"])) {
                                                        $line["P1 Ech"]=0;
                                                    }
                                                    if (empty($line["P2 Ech"])) {
                                                        $line["P2 Ech"]=0;
                                                    }
                                                    if (empty($line["P3 Ech"])) {
                                                        $line["P3 Ech"]=0;
                                                    }
                                                    if (empty($line["P4 Ech"])) {
                                                        $line["P4 Ech"]=0;
                                                    }
                                                    if (empty($line["P5 Ech"])) {
                                                        $line["P5 Ech"]=0;
                                                    }
                                                    try{

                                                        return RapportMed::create([

                                                            //'Date_de_visite' => $line["Date de visite"]->format('Y-m-d H:i:s'),
                                                            'Date_de_visite' => Carbon::parse($line['Date de visite'])->toDateTimeString(),
                                                            'Nom_Prenom' => $line["Nom Prenom"],
                                                            'Specialité' => $line["Specialité"],
                                                            'Etablissement' => $line["Etablissement"],
                                                            'Potentiel' => $line["Potentiel"],
                                                            'Montant_Inv_Précédents' => $line["Montant Inv Précédents"],
                                                            'Zone_Ville' => $line["Zone-Ville"],

                                                            'P1_présenté' => $line["P1 présenté"],
                                                            'P1_Feedback' => $line["P1 Feedback"],
                                                            'P1_Ech' => $line["P1 Ech"],

                                                            'P2_présenté' =>$line["P2 présenté"],
                                                            'P2_Feedback' => $line["P2 Feedback"],
                                                            'P2_Ech' => $line["P2 Ech"],

                                                            'P3_présenté' => $line["P3 présenté"],
                                                            'P3_Feedback' => $line["P3 Feedback"],
                                                            'P3_Ech' => $line["P3 Ech"],

                                                            'P4_présenté' => $line["P4 présenté"],
                                                            'P4_Feedback' => $line["P4 Feedback"],
                                                            'P4_Ech' => $line["P4 Ech"],

                                                            'P5_présenté' => $line["P5 présenté"],
                                                            'P5_Feedback' => $line["P5 Feedback"],
                                                            'P5_Ech' => $line["P5 Ech"],

                                                            'Materiel_Promotion' => $line["Materiel Promotion"],
                                                            'Invitation_promise' => $line["Invitation promise"],
                                                            'Plan/Réalisé' => $line["Plan/Réalisé"],
                                                            //'Visite_Individuelle/Double' => $line['Name'],
                                                            'DELEGUE' => $GLOBALS["Délégué"],
                                                            'DELEGUE_id' => 1

                                                            ]);

                                                            }
                                                        catch(\Exception  $e){

                                                            $CNF = 0;
                                                        }
                                            }
                                        });

                                        (new FastExcel)->sheet(4 )->import($file, function ($line)
                                        {

                                            if (!empty($line["PHARMACIE-ZONE"]) && $line["PHARMACIE-ZONE"] != 'PHARMACIE-ZONE' && ($line["Plan/Réalisé"] == "Réalisé" || $line["Plan/Réalisé"] == "Réalisé hors Plan"))
                                            {

                                                if (empty($line["P1 Nombre de boites"])) {
                                                    $line["P1 Nombre de boites"]=0;
                                                }
                                                if (empty($line["P2 Nombre de boites"])) {
                                                    $line["P2 Nombre de boites"]=0;
                                                }
                                                if (empty($line["P3 Nombre de boites"])) {
                                                    $line["P3 Nombre de boites"]=0;
                                                }
                                                if (empty($line["P4 Nombre de boites"])) {
                                                    $line["P4 Nombre de boites"]=0;
                                                }
                                                if (empty($line["P5 Nombre de boites"])) {
                                                    $line["P5 Nombre de boites"]=0;
                                                }
                                                try{


                                                return RapportPh::create([

                                                //'Date_de_visite' => $line["Date de visite"]->format('Y-m-d H:i:s'),
                                                'Date_de_visite' => Carbon::parse($line['Date de visite'])->toDateTimeString(),
                                                'pharmacie_zone' => $line["PHARMACIE-ZONE"],
                                                'Potentiel' => $line["Potentiel"],
                                                //'Zone_Ville' => $line["Zone-Ville"],

                                                'P1_présenté' => $line["P1 présenté"],
                                                'P1_nombre_boites' => $line["P1 Nombre de boites"],

                                                'P2_présenté' =>$line["P2 présenté"],
                                                'P2_nombre_boites' => $line["P2 Nombre de boites"],

                                                'P3_présenté' => $line["P3 présenté"],
                                                'P3_nombre_boites' => $line["P3 Nombre de boites"],

                                                'P4_présenté' => $line["P4 présenté"],
                                                'P4_nombre_boites' => $line["P4 Nombre de boites"],

                                                'P5_présenté' => $line["P5 présenté"],
                                                'P5_nombre_boites' => $line["P5 Nombre de boites"],


                                                'Plan/Réalisé' => $line["Plan/Réalisé"],
                                                //'Visite_Individuelle/Double' => $line['Name'],
                                                'DELEGUE' => $GLOBALS["Délégué"],
                                                'DELEGUE_id' => 1

                                                ]);

                                                }
                                                catch(\Exception  $e){

                                                    $CNF = 1;

                                                }
                                            }

                                        });
                                    }
                                    else{
                                        return redirect()->route('file_import_rapportMed')->withErrors(['Error' => 'Corrigez le nom  du fichier : '.$GLOBALS["file_name"]]);

                                    }
                            }
                            if ($CNF = 0){
                                return redirect()->route('file_import_rapportMed')->withErrors(['Error' => 'Vérifier les Colonnes rapport Med du Ficher  : '.$GLOBALS["file_name"]]);

                            }
                            elseif($CNF = 1){
                                return redirect()->route('file_import_rapportMed')->withErrors(['Error' => 'Vérifier les Colonnes rapport Ph du Ficher  : '.$GLOBALS["file_name"]]);

                            }
                            else{
                                return redirect()->route('show_rapport_med')->with('status','  File(s) uploaded successfully.');
                                    }

                        }


                    }

    public function show(){
        return view('import.rapportMed.show');
    }

    public function getRapportMed(){
        $rapportMed = RapportMed::all();
        return response()->json($rapportMed);
    }

  
    public function export(){

        //TODO : change request later
        $data_ph = RapportPh::where('rapport_ph_id','<=',2)->get();
        $data_med = RapportMed::where('rapport_med_id','<=',2)->get();
        //dd($data_med);

        if (!empty($data_ph->toArray()) && !empty($data_med->toArray())) {
            //Data exists

            //partie rapport ph
            foreach ($data_ph as $data) {
            
                $list_ph[] =
                [   'Date de visite' => $data['Date_de_visite'], 
                    'PHARMACIE-ZONE' => $data['pharmacie_zone'],
                    'Potentiel' => $data['Potentiel'],
                    'P présenté' => $data['P1_présenté'],
                    'P Nombre de boites' => $data['P1_nombre_boites'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'],
                ];
    
                $list_ph[] =
                [   'Date de visite' => $data['Date_de_visite'], 
                    'PHARMACIE-ZONE' => $data['pharmacie_zone'],
                    'Potentiel' => $data['Potentiel'],
                    'P présenté' => $data['P2_présenté'],
                    'P Nombre de boites' => $data['P2_nombre_boites'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'],
                ];
    
                $list_ph[] =
                [   'Date de visite' => $data['Date_de_visite'], 
                    'PHARMACIE-ZONE' => $data['pharmacie_zone'],
                    'Potentiel' => $data['Potentiel'],
                    'P présenté' => $data['P3_présenté'],
                    'P Nombre de boites' => $data['P3_nombre_boites'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'],
                ];
    
                $list_ph[] =
                [   'Date de visite' => $data['Date_de_visite'], 
                    'PHARMACIE-ZONE' => $data['pharmacie_zone'],
                    'Potentiel' => $data['Potentiel'],
                    'P présenté' => $data['P4_présenté'],
                    'P Nombre de boites' => $data['P4_nombre_boites'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'],
                ];
    
                $list_ph[] =
                [   'Date de visite' => $data['Date_de_visite'], 
                    'PHARMACIE-ZONE' => $data['pharmacie_zone'],
                    'Potentiel' => $data['Potentiel'],
                    'P présenté' => $data['P5_présenté'],
                    'P Nombre de boites' => $data['P5_nombre_boites'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'],
                ];
                
            }
            //partie rapport med
            foreach ($data_med as $data) {
            
                $list_med[] =
                [
                    'Date de visite' => $data['Date_de_visite'], 
                    'Nom Prenom' => $data['Nom_Prenom'],
                    'Specialité' => $data['Specialité'],
                    'Etablissement' => $data['Etablissement'],
                    'Potentiel' => $data['Potentiel'],
                    'Montant Inv Précédents' => $data['Montant_Inv_Précédents'],
                    'Zone' => $data['Zone_Ville'],
                    'P présenté' => $data['P1_présenté'],
                    'P Feedback' => $data['P1_Feedback'],
                    'P Ech' => $data['P1_Ech'],
                    'Materiel Promotion' => $data['Materiel_Promotion'],
                    'Invitation promise' => $data['Invitation_promise'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'],
                ];
    
                $list_med[] =
                [
                    'Date de visite' => $data['Date_de_visite'], 
                    'Nom Prenom' => $data['Nom_Prenom'],
                    'Specialité' => $data['Specialité'],
                    'Etablissement' => $data['Etablissement'],
                    'Potentiel' => $data['Potentiel'],
                    'Montant Inv Précédents' => $data['Montant_Inv_Précédents'],
                    'Zone' => $data['Zone_Ville'],
                    'P présenté' => $data['P2_présenté'],
                    'P Feedback' => $data['P2_Feedback'],
                    'P Ech' => $data['P2_Ech'],
                    'Materiel Promotion' => $data['Materiel_Promotion'],
                    'Invitation promise' => $data['Invitation_promise'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'],
                ];
    
                $list_med[] =
                [  
                    'Date de visite' => $data['Date_de_visite'], 
                    'Nom Prenom' => $data['Nom_Prenom'],
                    'Specialité' => $data['Specialité'],
                    'Etablissement' => $data['Etablissement'],
                    'Potentiel' => $data['Potentiel'],
                    'Montant Inv Précédents' => $data['Montant_Inv_Précédents'],
                    'Zone' => $data['Zone_Ville'],
                    'P présenté' => $data['P3_présenté'],
                    'P Feedback' => $data['P3_Feedback'],
                    'P Ech' => $data['P3_Ech'],
                    'Materiel Promotion' => $data['Materiel_Promotion'],
                    'Invitation promise' => $data['Invitation_promise'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'], 
                ];
    
                $list_med[] =
                [
                    'Date de visite' => $data['Date_de_visite'], 
                    'Nom Prenom' => $data['Nom_Prenom'],
                    'Specialité' => $data['Specialité'],
                    'Etablissement' => $data['Etablissement'],
                    'Potentiel' => $data['Potentiel'],
                    'Montant Inv Précédents' => $data['Montant_Inv_Précédents'],
                    'Zone' => $data['Zone_Ville'],
                    'P présenté' => $data['P4_présenté'],
                    'P Feedback' => $data['P4_Feedback'],
                    'P Ech' => $data['P4_Ech'],
                    'Materiel Promotion' => $data['Materiel_Promotion'],
                    'Invitation promise' => $data['Invitation_promise'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'],
                ];
    
                $list_med[] =
                [  
                    'Date de visite' => $data['Date_de_visite'], 
                    'Nom Prenom' => $data['Nom_Prenom'],
                    'Specialité' => $data['Specialité'],
                    'Etablissement' => $data['Etablissement'],
                    'Potentiel' => $data['Potentiel'],
                    'Montant Inv Précédents' => $data['Montant_Inv_Précédents'],
                    'Zone' => $data['Zone_Ville'],
                    'P présenté' => $data['P5_présenté'],
                    'P Feedback' => $data['P5_Feedback'],
                    'P Ech' => $data['P5_Ech'],
                    'Materiel Promotion' => $data['Materiel_Promotion'],
                    'Invitation promise' => $data['Invitation_promise'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'], 
                ];
                
            }

            $sheets = new SheetCollection([
                'Synt Hebdo DATA PH' => $list_ph,
                'Synt Hebdo DATA MED' => $list_med
            ]);
            
            return (new FastExcel($sheets))->download('Synt_hebdo.xlsx');

        }else{
            //No Data Exists
            //dd('no data exist');
            return redirect()->route('show_rapport_ph')->withErrors(['Error' => 'Il n\'existe aucune ligne à exporté !']);
        }

    }
    
}
