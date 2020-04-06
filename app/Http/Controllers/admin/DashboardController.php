<?php

namespace App\Http\Controllers\admin;


use App\Medecin;
use App\Secteur;
use App\Specialite;
use App\User;
use App\Ville;
use App\VisiteMedical;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ADMIN|SUPADMIN');
    }

    public function home(){
        $secteurs = Secteur::orderBy('created_at')->get();
        $specs = Specialite::orderBy('code')->select('specialite_id','code')->get();
        $medecins = Medecin::select('nom','prenom','specialite_id','ville_id','created_by')->latest()->take('10')->get();
        $villes = Ville::whereHas('visitesMedicals')->select('ville_id','libelle')->get();
        return view('admin.dashboard',compact('secteurs','medecins','specs','villes'));
    }


    public function visiteByDelegue(Request $request){
        if($request->ajax()) {
            $sect = $request->input('q');
            $beginDate =  Carbon::now()->subDays(90);
            $endDate = Carbon::now();

            $visites = Secteur::find($sect)->users()->select('nom','prenom')->withCount(['visiteMedicales' => function (Builder $query) use ($beginDate,$endDate) {
                $query->whereBetween('date_visite',[$beginDate,$endDate]);
            }])->get();

            return response()->json($visites,200);
        }
        return null;
    }


    public function visiteBySpec(Request $request){
      if($request->ajax()) {
            $sect = $request->input('sect');
            $spec = $request->input('spec');
            $beginDate =  Carbon::now()->subDays(90);
            $endDate = Carbon::now();

            $visites = Secteur::find($sect)->users()->select('nom','prenom')->withCount(['visiteMedicales' => function (Builder $query) use ($beginDate,$endDate,$spec) {
                $query->whereHas('medecin',function(Builder $bld) use ($spec) {
                          $bld->where('specialite_id','=',$spec);
                         })->where('etat','!=','plan')
                           ->whereBetween('date_visite',[$beginDate,$endDate]);
            }])->get();

            return response()->json($visites,200);

        }
        else{
            abort(403, 'Unauthorized action.');
        }

    }


    public function visiteByVilles(Request $request){

        if($request->ajax()) {
            $ville = $request->input('q');
            $beginDate =  Carbon::now()->subDays(90);
            $endDate = Carbon::now();

            $visites = Ville::find($ville)->users()->select('nom','prenom')->withCount(['visiteMedicales' => function (Builder $query) use ($beginDate,$endDate) {
                        $query->where('etat','!=','plan')
                               ->whereBetween('date_visite',[$beginDate,$endDate]);
            }])->get();
            return response()->json($visites,200);

        }

    }

}
