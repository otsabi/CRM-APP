<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Http\Requests\StoreVisiteMedical;
use App\Http\Requests\UpdateVisiteMedical;
use App\Produit;
use App\Role;
use App\Secteur;
use App\User;
use App\VisiteMedical;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class VisiteMedicalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:DSM|KAM|DM');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $visites = null;
        $user = Auth::user();
        if($request->has('type')){

            $validator = Validator::make($request->all(),[
                'type' => 'required|in:search',
                'date_debut' => 'required|date_format:d/m/Y',
                'date_fin' => 'required|date_format:d/m/Y|after_or_equal:date_debut',
                'etat' => 'nullable|in:Plan,Réalisé,Réalisé hors plan,Reporté',
            ],[
                'date_debut.*' => 'required|date_format:d/m/Y',
                'date_fin.*' => 'La date de fin doit être supérieure ou égale à la date de début',
                'etat.*' => 'Etat selectionné invalide',
            ]);

            if($validator->fails()){
               return redirect()->back()->withErrors($validator);
            }

            else{
                $date_debut = Carbon::createFromFormat('d/m/Y',$request->input('date_debut'))->format('Y-m-d');
                $date_fin =  Carbon::createFromFormat('d/m/Y',$request->input('date_fin'))->format('Y-m-d');
                $etat = $request->input('etat');
                $visites =  $user->visiteMedicales()->whereBetween('date_visite',[$date_debut,$date_fin]);

                if($etat != null) {
                    $visites = $visites->whereRaw('LOWER(etat) = LOWER(?)',[$etat]);
                }

                $visites = $visites->orderBy('date_visite','desc')->paginate(20);
                $visites = $visites->appends(['type' => 'search',
                    'date_debut' => $request->input('date_debut'),
                    'date_fin' => $request->input('date_fin'),
                    'etat' => $etat]
                );
            }

        }
        else{
           $visites = $user->visiteMedicales()->orderBy('date_visite','desc')->paginate(20);
        }

        return view('visites.medvisites.medvisite_index',compact('visites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gammes = Auth::user()->gammes->pluck('gamme_id');

        $produits = Produit::ofGammes($gammes)->get();
        $feedback = Feedback::select('feedback_id','libelle')->orderBy('libelle')->get();

        return view('visites.medvisites.create_medvisite',compact(['produits','feedback']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVisiteMedical $request)
    {
        $visite = new VisiteMedical();
        $visite->date_visite = Carbon::createFromFormat('d/m/Y',$request->input('date_v'))->toDateString();
        $visite->medecin_id = $request->input('med');
        $visite->etat = mb_strtolower($request->input('etat'));
        $visite->created_by = Auth::user()->nom . " " .  Auth::user()->prenom;
        $visite->valid = null;
        $visite->note = $request->input('note');
        $visite->user_id = Auth::id();

        $visite->save();

        if($request->has('product') && count($request->input('product')) > 0){
            for($i = 0;$i < count($request->input('product')); $i++){
                $visite->products()->attach($request->input('product.'.$i),
                    [
                        'feedback_id' => $request->input('feedback.'.$i),
                        'nbr_ech' => $request->input('ech.'.$i),
                    ]
                );
            }
        }
        return redirect()->back()->with('status','Visite médicale créé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visite = Auth::user()->visiteMedicales()->findOrfail($id);
        return view('visites.medvisites.medvisite_show',compact('visite'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visite = Auth::user()->visiteMedicales()->findOrfail($id);

        if(empty($visite)){
            return redirect()->back()->withErrors(['Error' => 'Une erreur s\'est produite lors du traitement de votre demande.']);
        }elseif ($visite->etat != "plan"){
            return redirect()->action('VisiteMedicalController@show',$visite->visitemed_id)->withErrors(['Error' => 'Vous avez le droit de modifier seulement les visites planifiées.']);
        }

        $gammes = Auth::user()->gammes->pluck('gamme_id');
        $produits = Produit::ofGammes($gammes)->get();

        $feedback = Feedback::select('feedback_id','libelle')->get();

        return view('visites.medvisites.medvisite_edit',compact(['visite','produits','feedback']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVisiteMedical $request, $id)
    {
        $visite = Auth::user()->visiteMedicales()->findOrfail($id);

        if(empty($visite)){
            return redirect()->back()->withErrors(['Error' => 'Une erreur s\'est produite lors du traitement de votre demande.']);
        }elseif ($visite->etat != "plan"){
            return redirect()->action('VisiteMedicalController@show',$visite->visitemed_id)->withErrors(['Error' => 'Vous avez le droit de modifier seulement les visites planifiées.']);
        }

        $visite->etat = mb_strtolower($request->input('new_etat'));
        $visite->note = $request->input('note');

        $visite->save();

        if($request->has('product') && count($request->input('product')) > 0){
            for($i = 0;$i < count($request->input('product')); $i++){
                $visite->products()->attach($request->input('product.'.$i),
                    [
                        'feedback_id' => $request->input('feedback.'.$i),
                        'nbr_ech' => $request->input('ech.'.$i),
                    ]
                );
            }
        }

        return redirect()->action('VisiteMedicalController@show',$visite->visitemed_id)->with('status','Visite modifiée avec succés.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $visite = Auth::user()->visiteMedicales()->findOrfail($id);

            if(empty($visite)){
                return redirect()->back()->withErrors(['Error' => 'Visite non supprimée, Une erreur s\'est produite lors du traitement de votre demande.']);
            }
            elseif ($visite->etat != "plan"){
                return redirect()->back()->withErrors(['Error' => 'Vous avez le droit de supprimer seulement les visites planifiées.']);
            }

            $visite->products()->detach();
            $visite->delete();

            return redirect()->back()->with('status','Visite Supprimée');
        }

       catch(\Exception $exception){
            return redirect()->back()->withErrors(['Error' => 'Une erreur s\'est produite lors du traitement de votre demande.']);
        }

    }



    public function validation_index(Request $request){
        $users = null;
        $visites = null;

        if(Auth::user()->isDistrictManager()){
            $users = Secteur::find(session('secteur'))->users()->where('user_id','<>',Auth::id())->select('user_id','nom','prenom')->get();
        } else {
            $users = Auth::user()->collaborateurs()->pluck('user_id','nom','prenom');
        }


        if ($request->filled('query')) {

            $validator = Validator::make($request->all(),[
                'query' =>'required|in:search',
                'date_d'=>'required|date_format:d/m/Y',
                'date_f' => 'required|date_format:d/m/Y|after_or_equal:date_d',
                'dm'=> 'required|in:'.$users->implode('user_id',','),
            ],
                [
                    'query' => 'Une erreur s\'est produite lors du traitement de votre demande.',
                    'date_d.*'=>'Date début invalide',
                    'date_f.*'=>'Date fin invalide',
                    'dm.*'=>'délégue choisi invalid.',
                ]
            );

            if($validator->fails()){
                return redirect()->route('medvisites.validation')->withErrors($validator);
            }

            $date_debut = Carbon::createFromFormat('d/m/Y',$request->input('date_d'))->format('Y-m-d');
            $date_fin =  Carbon::createFromFormat('d/m/Y',$request->input('date_f'))->format('Y-m-d');
            $user = $request->input('dm');

            $visites = VisiteMedical::when($date_debut,function($query) use ($date_debut){
                    $query->where('date_visite','>=',$date_debut);
                })->when($date_fin,function($query) use ($date_fin){
                    $query->where('date_visite','<=',$date_fin);
                })->when($users,function($query) use ($user){
                    $query->where('user_id',$user);
                })->where('etat','<>','plan')
                ->orderBy('date_visite','desc')->get();
            }

        return view('visites.medvisites.validate_visites',compact('users','visites'));
    }

    public function validation_update(Request $request,$id){
         try{
             $v = VisiteMedical::findOrfail($id);
             $v->valid = $request->input('validation_type');
             $v->validated_by = Auth::user()->nom . " " .  Auth::user()->prenom;
             $v->validation_note = $request->input('validation_note');
             $v->save();
             return redirect()->back()->with('status','Visite validée');
         }
         catch(\Exception $exception){
             return redirect()->back()->withErrors(['Error' => 'Une erreur s\'est produite lors du traitement de votre demande.']);
         }

    }

}
