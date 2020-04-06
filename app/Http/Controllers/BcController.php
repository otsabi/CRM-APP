<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Bc;


class BcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:DSM|KAM|DM');
    }

    public function index(Request $request)
    {

        $bcs = Auth::user()->bcs()->orderBy('date_demande')->get();
        return view('bcs.liste_bcs',compact('bcs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bcs.bc_add',compact(['medecins']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'med'=>'required|nullable|exists:medecins,medecin_id',
            'date_realisationbc'=>'required',
            'type_bc'=>'required|in:Billet,Hôtel,Congrès,Inscription,Journée,Formation,Matériel,Diner,Dejeuner,Petit-Dej,Autre',
            'destination_bc'=> 'nullable|min:5',
            'detail_bc'=> 'required|min:5',
            'montant_bc'=> 'required|integer|min:0',
            'engagement_bc'=>'nullable|in:faible,moyen,elevé',
        ],
            [

            'med.*'=>'Médecin choisis invalid.',
            'date_realisationbc.*'=>'Date de réalisation invalide',
            'type_bc.*' => 'Type d\'investissement choisi invalid',
            'destination_bc.*'=> 'La destination doit comporter au moins 5 caractères.',
            'detail_bc.*'=> 'Détail du BC doit comporter au moins 5 caractères.',
            'montant_bc.*'=> 'Montant doit etre positive',
            'engagement_bc.*'=> 'Engagement choisi invalid.',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $bc = new Bc();

        $bc->medecin_id = $request->input('med');
        $bc->date_demande = Carbon::now()->format('Y-m-d');
        $bc->date_realisation = Carbon::createFromFormat('d/m/Y',$request->input('date_realisationbc'))->toDateString();
        $bc->type = $request->input('type_bc');
        $bc->destination = $request->input('destination_bc');
        $bc->detail = $request->input('detail_bc');
        $bc->montant = $request->input('montant_bc');
        $bc->etat ='en cours';
        $bc->satisfaction = null;
        $bc->engagement = $request->input('engagement_bc');
        $bc->user_id = Auth::user()->user_id;
        $bc->created_by = Auth::user()->nom . ' ' .  Auth::user()->prenom;

        $bc->save();

        return redirect()->back()->with('status','Votre demande a été enregistré avec succès.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bc  $bc
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bc = Auth::user()->bcs()->findOrfail($id);

        return view('bcs.bc_show',compact('bc'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bc  $bc
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bc = Auth::user()->bcs()->findOrfail($id);

        if($bc->etat === 'en cours'){
            return view('bcs.bc_edit',compact('bc'));
        }

        return redirect()->route('bcs.show', ['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bc  $bc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $bc = Auth::user()->bcs()->findOrfail($id);

        if($bc->etat === 'en cours'){

            $validator = Validator::make($request->all(),[
                'date_realisation_bc'=>'required',
                'type_bc'=>'required|in:Billet,Hôtel,Congrès,Inscription,Journée,Formation,Matériel,Diner,Dejeuner,Petit-Dej,Autre',
                'destination_bc'=>'nullable|min:5',
                'detail_bc'=>'required|min:5',
                'montant_bc'=>'required|integer|min:0',
                'engagement_bc'=>'nullable|in:faible,moyen,elevé',
            ],[
                'date_realisation_bc.*'=>'la date de réalisation est invalide',
                'type_bc.*'=>'le type d\'investisement invalid',
                'destination_bc.*'=>'la destination est invalide',
                'detail_bc.*'=> 'Détail du BC doit comporter au moins 5 caractères.',
                'montant_bc.*'=>'le montant du bc est invalide',
                'engagement_bc.*'=> 'Engagement choisi invalid.',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }

            $bc->date_realisation = Carbon::createFromFormat('d/m/Y',$request->input('date_realisation_bc'))->toDateString();
            $bc->type = $request->input('type_bc');
            $bc->destination = $request->input('destination_bc');
            $bc->detail = $request->input('detail_bc');
            $bc->montant = $request->input('montant_bc');
            $bc->engagement = $request->input('engagement_bc');
            $bc->save();

            return redirect()->route('bcs.show',['id'=>$bc->bc_id])->with('status','Vos modifications sont enregistrées avec succès.');

        }

        return redirect()->back()->withErrors(['Error' => 'Vous ne pouvez pas modifier ce business case']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bc  $bc
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bc = Auth::user()->bcs()->findOrfail($id);

        if($bc->etat !== 'en cours'){
           return redirect()->back()->withErrors(['Error' => 'Vous ne pouvez pas supprimer ce business case']);
        }

        $bc->delete();

        return redirect()->route('bcs.index')->with('status','Business case supprimé avec succès');
    }
}
