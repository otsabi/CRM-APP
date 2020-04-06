<?php

namespace App\Observers;

use App\Pharmacie;
use App\Pharmacie_history;
use App\Ville;
use App\Med_pharma_history;
use Illuminate\Support\Facades\Auth;

class PharmacieObserver
{
    /**
     * Handle the pharmacie "created" event.
     *
     * @param  \App\Pharmacie  $pharmacie
     * @return void
     */
    public function created(Pharmacie $pharmacie)
    {
        //
    }

    /**
     * Handle the pharmacie "updated" event.
     *
     * @param  \App\Pharmacie  $pharmacie
     * @return void
     */
    public function updated(Pharmacie $pharmacie)
    {



        if (!$pharmacie->wasRecentlyCreated) {

            $original = $pharmacie->getOriginal();
        $changes = array();

            $pharmacie->isDirty('ville_id') ? array_push($changes,$this->storeChangedColumn('Ville',Ville::find($original['ville_id'])->libelle,Ville::find($pharmacie->ville_id)->libelle)) : null;
            $pharmacie->isDirty('libelle') ? array_push($changes,$this->storeChangedColumn('libelle',$original['libelle'],$pharmacie->libelle)) : null;
            $pharmacie->isDirty('tel') ? array_push($changes,$this->storeChangedColumn('Telephone',$original['tel'],$pharmacie->tel)) : null;
            $pharmacie->isDirty('adresse ') ? array_push($changes,$this->storeChangedColumn('Adresse',$original['adresse'],$pharmacie->adresse)) : null;
            $pharmacie->isDirty('zone_ph') ? array_push($changes,$this->storeChangedColumn('Zone_ph',$original['zone_ph'],$pharmacie->zone_ph)) : null;
            $pharmacie->isDirty('potentiel') ? array_push($changes,$this->storeChangedColumn('Potentiel',$original['potentiel'],$pharmacie->potentiel)) : null;

            $Mp_history = new Med_pharma_history();

             $Mp_history->changes =  json_encode($changes);
             $Mp_history->created_by =  Auth::user()->nom . ' ' .  Auth::user()->prenom;
             $Mp_history->event      =  'update';
             $Mp_history->table      =  'Pharmacie';
             $Mp_history->model_id = $pharmacie->pharmacie_id;
             $Mp_history->save();


        }

    }

    /**
 * Handle the pharmacie "deleted" event.
     *
     * @param  \App\Pharmacie  $pharmacie
     * @return void
     */
    public function deleted(Pharmacie $pharmacie)
    {
        $Mp_history = new Med_pharma_history();
        $changes = array();
        array_push($changes,$pharmacie);
        $Mp_history->changes =  json_encode($changes);
        $Mp_history->created_by =  Auth::user()->nom . ' ' .  Auth::user()->prenom;
        $Mp_history->event      =  'deleted';
        $Mp_history->table      =  'Pharmacie';
        $Mp_history->model_id   = null;
        $Mp_history->save();

    }

    /**
     * Handle the pharmacie "restored" event.
     *
     * @param  \App\Pharmacie  $pharmacie
     * @return void
     */
    public function restored(Pharmacie $pharmacie)
    {
        //
    }

    /**
     * Handle the pharmacie "force deleted" event.
     *
     * @param  \App\Pharmacie  $pharmacie
     * @return void
     */
    public function forceDeleted(Pharmacie $pharmacie)
    {
        //
    }



    private function storeChangedColumn($name,$oldValue,$newValue)
    {
           $v = array('column' => $name,'old_value'=>$oldValue,'new_value'=>$newValue);
           return $v;
    }
}
