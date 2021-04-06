<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            "firstName"=>'required|regex:/^[A-Z][a-z]{2,19}$/',
            "lastName"=>'required|regex:/^[A-Z][a-z]{2,29}$/',
            "email"=>'required|regex:/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/',
            "password"=>'nullable|regex:/^.{8,15}$/'
        ];
    }

    public function messages()
    {
        return [
            "firstName.regex"=>"First name begins with capital letter nad have 3 letters minimum, 20 maximum",
            "lastName.regex"=>"Last name begins with capital letter nad have 3 letters minimum, 30 maximum",
            "email.regex"=>"E-mail formats: milica@gmail.com or milica.jovanovic.88.18@ict.edu.rs",
            "password.regex"=>"Password has minimum 8, maximum 5 characters"
        ];
    }
}
