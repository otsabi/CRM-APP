<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;
use App\RapportPh;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RapportPhController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:SUPADMIN|ADMIN');
    }

    public function index(){
        return view('import.rapportPh.index');
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
        $GLOBALS["CNF"] = '';
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
                        'ABDERRAHMANE',
                        'ZAKARIA TEMSAMANI',
                        'HICHAM EL MOUSTAKHIB',
                        'HOUDA HMIDAY');

                    $files = $request->file('import_file');

                    if($request->hasFile('import_file')){
                        foreach ($files as $file) {


                            $GLOBALS["file_name"]= $file->getClientOriginalName();
                            $GLOBALS["Délégué"] = $this->delegue_from_name_file($file->getClientOriginalName(), $DMs);

                            if($GLOBALS["Délégué"] != FALSE){
                                (new FastExcel)->sheet(5)->import($file, function ($line) {

                                    //dd($line);

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
                                            //'DELEGUE_id' => 1

                                        ]);//end return create
                                    }
                                    catch(\Exception  $e){

                                        $GLOBALS["CNF"] = 1;
                                        //echo $e->getMessage();
                                    }

                                }//end if test Plan/Réalisé


                        });//end FastExcel)->sheet(5)

         }else{
            return redirect()->route('file_import_rapportMed')->withErrors(['Error' => 'Corrigez le nom  du fichier : '.$GLOBALS["file_name"]]);

        }//$GLOBALS["Délégué"] != FALSE

                    }//end foreach
                    //dd($GLOBALS["CNF"]);
                    if ($GLOBALS["CNF"] === 1){
                        //echo 'result : '.$GLOBALS["CNF"];
                        return redirect()->route('file_import_rapportPh')->withErrors(['Error' => 'Vérifier les Colonnes rapport Ph du Ficher  : '.$GLOBALS["file_name"]]);
                    }
                    else{
                        return redirect()->route('show_rapport_ph')->with('status','  File(s) uploaded successfully.');
                    }

                }//end $request->hasFile

}//end function

    public function show(){
        return view('import.rapportPh.show');
    }

    public function getRapportPh(){
        $rapportPh = RapportPh::all();
        return response()->json($rapportPh);
    }

    public function export(){

        $data_ph = RapportPh::where('rapport_ph_id','<=',2)->get();

        if (!empty($data_ph->toArray())) {
            //Data exists
            foreach ($data_ph as $data) {

                $list[] =
                [   'Date de visite' => Carbon::parse($data['Date_de_visite'])->format('d/m/Y'),
                    'PHARMACIE-ZONE' => $data['pharmacie_zone'],
                    'Potentiel' => $data['Potentiel'],
                    'P présenté' => $data['P1_présenté'],
                    'P Nombre de boites' => $data['P1_nombre_boites'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'],
                ];

                $list[] =
                [   'Date de visite' => Carbon::parse($data['Date_de_visite'])->format('d/m/Y'),
                    'PHARMACIE-ZONE' => $data['pharmacie_zone'],
                    'Potentiel' => $data['Potentiel'],
                    'P présenté' => $data['P2_présenté'],
                    'P Nombre de boites' => $data['P2_nombre_boites'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'],
                ];

                $list[] =
                [   'Date de visite' => Carbon::parse($data['Date_de_visite'])->format('d/m/Y'),
                    'PHARMACIE-ZONE' => $data['pharmacie_zone'],
                    'Potentiel' => $data['Potentiel'],
                    'P présenté' => $data['P3_présenté'],
                    'P Nombre de boites' => $data['P3_nombre_boites'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'],
                ];

                $list[] =
                [   'Date de visite' => Carbon::parse($data['Date_de_visite'])->format('d/m/Y'),
                    'PHARMACIE-ZONE' => $data['pharmacie_zone'],
                    'Potentiel' => $data['Potentiel'],
                    'P présenté' => $data['P4_présenté'],
                    'P Nombre de boites' => $data['P4_nombre_boites'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'],
                ];

                $list[] =
                [   'Date de visite' => Carbon::parse($data['Date_de_visite'])->format('d/m/Y'),
                    'PHARMACIE-ZONE' => $data['pharmacie_zone'],
                    'Potentiel' => $data['Potentiel'],
                    'P présenté' => $data['P5_présenté'],
                    'P Nombre de boites' => $data['P5_nombre_boites'],
                    'Plan/Réalisé' => $data['Plan/Réalisé'],
                    'DELEGUE' => $data['DELEGUE'],
                ];

            }

            //return (new FastExcel($list))->download('file.xlsx');

            $sheets = new SheetCollection([
                'Synt Hebdo DATA PH' => $list
            ]);

            return (new FastExcel($sheets))->download('Synt_hebdo.xlsx');

        }else{
            //No Data Exists
            //dd('no data exist');
            return redirect()->route('show_rapport_ph')->withErrors(['Error' => 'Il n\'existe aucune ligne à exporté !']);
        }

    }
}
