<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
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
        $this->middleware('role:SUPADMIN');
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

                //intialise an array od DM with their ID
                $DMs = array();
                $DMs[1]= "ELOUADEH";
                $DMs[2]= "IDDER";


                        $files = $request->file('import_file');

                        if($request->hasFile('import_file'))
                        {
                            foreach ($files as $file) {
                                //THIS FIRST IS FOR LARAVEL-EXCEL PACKAGE
                                //Excel::import(new FileImport, $file);

                                //store original name of file.
                                //$GLOBALS["original_name"] = $file->getClientOriginalName();

                                $GLOBALS["Délégué"] = $this->delegue_from_name_file($file->getClientOriginalName(), $DMs);

                            if ($GLOBALS["Délégué"]) {
                                    
                                (new FastExcel)->sheet(3)->import($file, function ($line) {
                                
                                    
                                    if (!empty($line["Nom Prenom"]) && ($line["Plan/Réalisé"] == "Réalisé" || $line["Plan/Réalisé"] == "Réalisé hors Plan")) {


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
                                    //'DELEGUE_id' => 1

                                    ]);

                                    }

                                    //var_dump($line["Montant Inv Précédents"]);
                                    //dd($line);

                                    //  $date = DateTime::createFromFormat('j-M-Y', $line["Date de visite"]);
                                    //  echo $date->format('Y-m-d');
                                     //var_dump(Date::excelToDateTimeObject($line["Date de visite"])->format('Y-m-d'));

                                     //$date = $line["Date de visite"];

                                     //var_dump($date->date);
                                     //print_r($date);
                                        //echo $date["date"];
                                });
                                (new FastExcel)->sheet(4)->import($file, function ($line) {

                                    if (!empty($line["PHARMACIE-ZONE"]) && ($line["Plan/Réalisé"] == "Réalisé" || $line["Plan/Réalisé"] == "Réalisé hors Plan")) {

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
                                    //'DELEGUE_id' => 1

                                    ]);
                                     

                                    }

                                });

                            }else{
                                dd("we can not find Delegue name !");
                            }

                            }
                            return redirect()->action('RapportMedController@show')->with('status','ajouté avec succès.');
                        }

                    }

    public function show(){
        return view('import.rapportMed.show');
    }
    public function getRapportMed(){
        $rapportMed = RapportMed::all();
        return response()->json($rapportMed);
    }
}
