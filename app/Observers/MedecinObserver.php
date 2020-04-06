<?php

namespace App\Observers;

use App\Medecin;
use App\Ville;
use App\Specialite;
use App\Med_pharma_history;
use Illuminate\Support\Facades\Auth;

class MedecinObserver
{
    /**
     * Handle the medecin "created" event.
     *
     * @param  \App\Medecin  $medecin
     * @return void
     */ 
    public function created(Medecin $medecin)
    {
        //
    }

    /**
     * Handle the medecin "updated" event.
     *
     * @param  \App\Medecin  $medecin
     * @return void
     */
    public function updated(Medecin $medecin)
    {
        $Mp_history = new Med_pharma_history();

        if (!$medecin->wasRecentlyCreated) {

            $original = $medecin->getOriginal();
        $changes = array();

            $medecin->isDirty('nom') ? array_push($changes,$this->storeChangedColumn('nom',$original['prenom'],$medecin->prenom)) : null;

            $medecin->isDirty('prenom') ? array_push($changes,$this->storeChangedColumn('Prenom',$original['prenom'],$medecin->prenom)) : null;
            $medecin->isDirty('specialite_id') ? array_push($changes,$this->storeChangedColumn('Spécialité',Specialite::find($original['specialite_id'])->code,Specialite::find($medecin->specialite_id)->code)) : null;
            $medecin->isDirty('adresse ') ? array_push($changes,$this->storeChangedColumn('Adresse',$original['adresse'],$medecin->adresse)) : null;
            $medecin->isDirty('tel') ? array_push($changes,$this->storeChangedColumn('Telephone',$original['tel'],$medecin->tel)) : null;
            $medecin->isDirty('etablissement') ? array_push($changes,$this->storeChangedColumn('Etablissement',$original['etablissement'],$medecin->etablissement)) : null;
            $medecin->isDirty('potentiel') ? array_push($changes,$this->storeChangedColumn('Potentiel',$original['potentiel'],$medecin->potentiel)) : null;
            $medecin->isDirty('zone_med') ? array_push($changes,$this->storeChangedColumn('Zone',$original['zone_med'],$medecin->zone_med)) : null;
            $medecin->isDirty('ville_id') ? array_push($changes,$this->storeChangedColumn('Ville',Ville::find($original['ville_id'])->libelle,Ville::find($medecin->ville_id)->libelle)) : null;


            $Mp_history->changes =  json_encode($changes);
            $Mp_history->created_by =  Auth::user()->nom . ' ' .  Auth::user()->prenom;
            $Mp_history->event      =  'update';
            $Mp_history->table      =  'Medecin';
            $Mp_history->model_id = $medecin->medecin_id;
            $Mp_history->save();
        }
    }

    /**
     * Handle the medecin "deleted" event.
     *
     * @param  \App\Medecin  $medecin
     * @return void
     */
    public function deleted(Medecin $medecin)
    {
        //
        $Mp_history = new Med_pharma_history();
        $changes = array();
        array_push($changes,$medecin);
        $Mp_history->changes =  json_encode($changes);
        $Mp_history->created_by =  Auth::user()->nom . ' ' .  Auth::user()->prenom;
        $Mp_history->event      =  'deleted';
        $Mp_history->table      =  'Medecin';
        $Mp_history->model_id   = null;
        $Mp_history->save();

    }

    /**
     * Handle the medecin "restored" event.
     *
     * @param  \App\Medecin  $medecin
     * @return void
     */
    public function restored(Medecin $medecin)
    {
        //
    }

    /**
     * Handle the medecin "force deleted" event.
     *
     * @param  \App\Medecin  $medecin
     * @return void
     */
    public function forceDeleted(Medecin $medecin)
    {
        //
    }


    private function storeChangedColumn($name,$oldValue,$newValue)
    {
           $v = array('column' => $name,'old_value'=>$oldValue,'new_value'=>$newValue);
           return $v;
    }



}

