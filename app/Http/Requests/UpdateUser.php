<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUser extends FormRequest
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
            'user_email'=>array('required','email',Rule::unique('users','email')->ignore($this->route('user'), 'user_id')),
            'user_tel' => array('nullable','regex:/^0[5-6]{1}[0-9]{2}-[0-9]{6}/m'),
            'user_ville'=>'required|exists:villes,ville_id',
            'user_role'=>'required|exists:roles,role_id',
            'user_gamme'=>'required|array|exists:gammes,gamme_id',
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
            'user_tel' => 'téléphone doit respecter format suivante : 0000-000000',
            'user_ville.*'=>'la ville sélectionneé est invalide',
            'user_role.*'=>'le role sélectionné est invalid',
            'user_gamme.*'=>'vous devez choisissez au mois une gammes',
            'user_manager.*'=>'le manager sélectionné est invalid',
        ];
    }
}
