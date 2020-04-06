<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewUser extends FormRequest
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
            'user_nom'=>'required|min:3|max:30',
            'user_prenom'=>'required|min:3|max:30',
            'user_title'=>'required|in:Mr,Mlle,Mme',
            'user_email'=>'required|email|unique:users,email',
            'user_tel' => array('nullable','regex:/^0[5-6]{1}[0-9]{2}-[0-9]{6}/m'),
            'password'=>'required|confirmed|min:6|max:40',
            'password_confirmation'=>'required',
            'user_ville'=>'required|exists:villes,ville_id',
            'user_role'=>'required|exists:roles,role_id',
            'user_gamme'=>'required|array',
            'user_gamme.*'=>'exists:gammes,gamme_id',
            'user_manager'=>'nullable|exists:users,user_id',
        ];
    }

    public function messages()
    {
        return [
            'user_nom.*'=>'le nom d\'utilisateur est invalid.',
            'user_prenom.*'=>'le prenom d\'utilisateur est invalid',
            'user_title.*'=>'le title est vide',
            'user_email.*'=>'Votre email est invalid ou déja pris',
            'password.*'=>'Mot de passe invalid',
            'user_tel' => 'téléphone doit respecter format suivante : 0000-000000',
            'password_confirmation.*'=>'les mots de passe ne correspondent pas',
            'user_ville.*'=>'la ville sélectionneé est invalide',
            'user_role.*'=>'le role sélectionné est invalid',
            'user_gamme.*'=>'vous devez choisissez au mois une gammes',
            'user_manager.*'=>'le manager sélectionné est invalid',
        ];
    }
}
