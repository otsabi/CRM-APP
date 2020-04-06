<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisitePharma extends FormRequest
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
            'date_v' => 'required|date_format:d/m/Y',
            'etat' => 'required|in:Réalisé hors plan,Plan',
            'pharma' => 'required|exists:pharmacies,pharmacie_id',
            'product.*' =>'required_unless:etat,Plan|exists:produits,produit_id',
            'nbr_b.*' =>'required_unless:etat,Plan|min:0|max:100',
            'note' => 'nullable|max:250',
        ];
    }

    public function messages(){
        return [
            'date_v.*' => 'la date de visite est invalide.',
            'etat.*' => 'L\'etat de visite doit être : Réalisé hors plan ou Plan.',
            'pharma.*' => 'Pharmacie invalide.',
            'product.required_unless' =>'les produits présentés sont requis lorsque l\'etat de visite est : Réalisé hors plan.',
            'product.*' =>'Vous avez choisi un produit qui n\'existe pas.',
            'nbr_b.*' =>'Le nombre des boîtes doit être entre 0 et 100.',
        ];
    }

}
