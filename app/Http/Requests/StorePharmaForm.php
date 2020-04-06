<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePharmaForm extends FormRequest
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
            'pharmacie_nom'=>'required|min:3',
            'pharmacie_ville'=>'required|nullable|exists:villes,ville_id',
            'pharmacie_tel' => array('nullable','regex:/^0[5-6]{1}[0-9]{2}-[0-9]{6}/m'),
            'pharmacie_adress'=>'required|min:5',
            'pharmacie_zone'=>'required|min:4',
            'pharmacie_potentiel'=> 'required|in:A,B,C,D'
        ];
    }

    public function messages(){
        return [
            'pharmacie_nom.*'=>'le nom du Pharmacie est invalid.',
            'pharmacie_tel.*' =>'Téléphone invalid - le format doit être : 0000-000000',
            'pharmacie_ville.*'=>'la ville sélectionné est invalid',
            'pharmacie_adress.*'=>'ladresse que vous avez saisie est incomplète',
            'pharmacie_zone.*'=>'la zone de la pharmacie que vous avez saisie est incomplète',
            'pharmacie_potentiel.*'=> 'la Potentiel sélectionné est invalid',
        ];
    }
}
