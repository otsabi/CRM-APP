<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitePharma;
use App\Http\Requests\UpdateVisitePharma;
use App\VisitePharmacie;
use Illuminate\Http\Request;
use App\Produit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class VisitePharmacieController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:DSM|KAM|DM|DPH');
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
                $etat = $request->input('etat') ;
                $visites =  $user->visitePharmacies()->whereBetween('date_visite',[$date_debut,$date_fin]);

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
            $visites = $user->visitePharmacies()->orderBy('date_visite','desc')->paginate(20);
        }

        return view('visites.phvisites.phvisite_index',compact('visites'));

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
        return view('visites.phvisites.create_phvisite',compact('produits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVisitePharma $request)
    {
        $visite = new VisitePharmacie();
        $visite->date_visite = Carbon::createFromFormat('d/m/Y',$request->input('date_v'))->toDateString();
        $visite->pharmacie_id = $request->input('pharma');
        $visite->etat = mb_strtolower($request->input('etat'));
        $visite->created_by = Auth::user()->nom . " " .  Auth::user()->prenom;
        $visite->note = $request->input('note');
        $visite->user_id = Auth::id();

        $visite->save();

        if($request->has('product') && count($request->input('product')) > 0){
            for($i = 0;$i < count($request->input('product')); $i++){
                $visite->products()->attach($request->input('product.'.$i),
                    [
                        'nb_boites' => $request->input('nbr_b.'.$i),
                    ]
                );
            }
        }

        return redirect()->back()->with('status','Visite pharmacie créé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visite = Auth::user()->visitePharmacies()->findOrfail($id);

        return view('visites.phvisites.phvisite_show',compact('visite'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visite = Auth::user()->visitePharmacies()->findOrfail($id);

        if(empty($visite)){
            return redirect()->back()->withErrors(['Error' => 'Une erreur s\'est produite lors du traitement de votre demande.']);
        }elseif ($visite->etat != "plan"){
            return redirect()->action('VisitePharmacieController@show',$visite->visitephar_id)->withErrors(['Error' => 'Vous avez le droit de modifier seulement les visites planifiées.']);
        }

        $gammes = Auth::user()->gammes->pluck('gamme_id');

        $produits = Produit::ofGammes($gammes)->get();

        return view('visites.phvisites.phvisite_edit',compact(['visite','produits']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVisitePharma $request, $id)
    {

        $visite = Auth::user()->visitePharmacies()->findOrfail($id);

        if(empty($visite)){
            return redirect()->back()->withErrors(['Error' => 'Une erreur s\'est produite lors du traitement de votre demande.']);
        }elseif ($visite->etat != "plan"){
            return redirect()->action('VisitePharmacieController@show',$visite->visitephar_id)->withErrors(['Error' => 'Vous avez le droit de modifier seulement les visites planifiées.']);
        }

        $visite->etat = mb_strtolower($request->input('new_etat'));
        $visite->note = $request->input('note');
        $visite->save();

        if($request->has('product') && count($request->input('product')) > 0){
            for($i = 0;$i < count($request->input('product')); $i++){
                $visite->products()->attach($request->input('product.'.$i),
                    [
                        'nb_boites' => $request->input('nbr_b.'.$i),
                    ]
                );
            }
        }

        return redirect()->action('VisitePharmacieController@show',$visite->visitephar_id)->with('status','Visite modifiée avec succés.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $visite = Auth::user()->visitePharmacies()->findOrfail($id);

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
}
