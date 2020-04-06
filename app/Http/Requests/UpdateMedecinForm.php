<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedecinForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nom' => 'required|alpha|min:3|max:30',
            'prenom' => 'required|alpha|min:3|max:30',
            'spec' => 'required|exists:specialites,specialite_id',
            'etab' =>'required|in:privé,chu,hopital,autre',
            'potentiel' =>'nullable|in:A,B,C,D',
            'ville' =>'required|exists:villes,ville_id',
            'zone' => 'nullable|max:30',
            'tel'=>array('nullable','regex:/^0[5-6]{1}[0-9]{2}-[0-9]{6}/m'),
            'adress'=>'nullable|max:250',
        ];
    }

    public function messages(){
        return [
            'nom.*' => 'nom du médecin invalid (min car:3 et max car:30).',
            'prenom.*' => 'prenom du médecin invalid (min car:3 et max car:30).',
            'spec.*' => 'Specialité invalide ou n\'existe pas.',
            'etab.*' =>'Etablissement invalide ou n\'existe pas.',
            'potentiel.*' =>'Vous avez choisi un mouvais potentiel.',
            'ville.*' =>'Ville invalide ou n\'existe pas.',
            'zone.*' =>'Zone invalide (max car:30)',
            'tel.*' =>'Téléphone invalid - le format doit être : 0000-000000',
            'adress.*' =>'Adresse est trop longue',
        ];
    }
}
