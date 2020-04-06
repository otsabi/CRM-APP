<?php

namespace App\Http\Controllers;

use App\Medecin;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    }

    public function home(){
        $user = Auth::user();

        $nbr_v_mois = $user->visiteMedicales()
                            ->whereBetween('date_visite',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
                            ->where('etat','!=','plan')
                            ->count();

        $nbr_ph_mois = $user->visitePharmacies()
                            ->whereBetween('date_visite',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
                            ->where('etat','!=','plan')
                            ->count();

        $nbr_v_week = $user->visiteMedicales()->whereBetween('date_visite',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->where('etat','!=','plan')->count();
        $nbr_ph_week = $user->visitePharmacies()->whereBetween('date_visite',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->where('etat','!=','plan')->count();


        $medecins = Medecin::select('medecin_id','nom','prenom','specialite_id')->whereHas('visites',function (Builder $query) use($user){
            $query->where('user_id',$user->user_id);
        })->withCount(['visites' => function(Builder $query) use ($user) {
            $query->where('user_id',$user->user_id)->where('etat','!=','plan');
        }])->orderBy('visites_count','desc')->take(15)->get();



        return view('home',compact([
            'nbr_v_mois',
            'nbr_ph_mois',
            'nbr_v_week',
            'nbr_ph_week',
            'medecins'
        ]));
    }

    public function visiteBySpecialite(Request $request){

         if($request->ajax()){

            $request->validate([
                'timeRange' => 'nullable|in:month,ninthyday',
            ]);

            $beginDate = $request->input('timeRange') === 'ninthyday' ?  Carbon::now()->subDays(90) : Carbon::now()->startOfMonth();
            $endDate = $request->input('timeRange') === 'ninthyday' ?  Carbon::now() : Carbon::now()->endOfMonth();


            $spec = DB::table('visite_medicals')
                ->select('specialites.code',DB::raw('count(*) as nombreVisites'))
                ->join('medecins','visite_medicals.medecin_id','=','medecins.medecin_id')
                ->join('specialites','medecins.specialite_id','=','specialites.specialite_id')
                ->whereBetween('visite_medicals.date_visite',[$beginDate,$endDate])
                ->where('visite_medicals.user_id',Auth::id())
                ->groupBy('specialites.code')
                ->get();



            return response()->json($spec,200);


        }
           return null;
    }

    public function visiteByVille(Request $request){

        if($request->ajax()){

            $request->validate([
                'timeRange' => 'nullable|in:month,ninthyday',
            ]);

            $beginDate = $request->input('timeRange') === 'ninthyday' ?  Carbon::now()->subDays(90) : Carbon::now()->startOfMonth();
            $endDate = $request->input('timeRange') === 'ninthyday' ?  Carbon::now() : Carbon::now()->endOfMonth();

            $spec = DB::table('visite_medicals')
                ->select('villes.libelle',DB::raw('count(*) as nombreVisites'))
                ->join('medecins','visite_medicals.medecin_id','=','medecins.medecin_id')
                ->join('villes','medecins.ville_id','=','villes.ville_id')
                ->whereBetween('visite_medicals.date_visite',[$beginDate,$endDate])
                ->where('visite_medicals.user_id',Auth::id())
                ->groupBy('villes.libelle')
                ->get();

            return response()->json($spec,200);
        }
        return null;
    }


}
