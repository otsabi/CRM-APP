<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVisitePharma extends FormRequest
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
            'new_etat' => 'required|in:Réalisé,Reporté',
            'product.*' =>'required_unless:new_etat,Reporté|exists:produits,produit_id',
            'nbr_b.*' =>'required_unless:new_etat,Reporté|min:0|max:2',
            'note' => 'nullable|max:250',
        ];
    }

    public function messages(){
        return [
            'new_etat.*' => 'L\'etat de visite doit être: Réalisé ou Reporté.',
            'product.required_unless' =>'les produits présentés sont requis lorsque l\'etat de visite est : Réalisé.',
            'product.*' =>'Vous avez choisi un produit qui n\'existe pas.',
            'nbr_b.*' =>'Le nombre des boîtes doit être entre 0 et 100.',
        ];
    }
}
