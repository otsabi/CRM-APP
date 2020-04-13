<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\RapportPh;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class RapportPhController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:SUPADMIN');
    }




    public function index(){
        return view('import.rapportPh.index');
    }

    public function import(Request $request){
                set_time_limit(500);
                        $files = $request->file('import_file');

                        if($request->hasFile('import_file'))
                        {
                            foreach ($files as $file) {
                                //THIS FIRST IS FOR LARAVEL-EXCEL PACKAGE
                                //Excel::import(new FileImport, $file);
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
                                    if ($line["Plan/Réalisé"] === 'Réalisé' or 'Réalisé hors Plan' ){

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
                                    'DELEGUE' => "EL MEHDI AIT FAKIR",
                                    'DELEGUE_id' => 1

                                    ]);

                                    }
                                }

                                });

                            }
                            return redirect()->action('RapportPhController@show')->with('status','ajouté avec succès.');

                        }

                    }

    public function show(){
        return view('import.rapportPh.show');
    }
    public function getRapportPh(){
        $rapportPh = RapportPh::all();
        return response()->json($rapportPh);
    }
}
