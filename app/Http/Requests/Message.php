<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Message extends FormRequest
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
            "fName"=>'regex:/^[A-Z][a-z]{2,19}$/',
            "lName"=>'regex:/^[A-Z][a-z]{2,29}$/',
            "email"=>'regex:/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/',
            "subject"=>'regex:/^[\w\s\d]+$/',
            "message"=>'required|min:10'
        ];
    }

    public function messages()
    {
        return [
            "fName.regex"=>"First name begins with capital letter nad have 3 letters minimum, 20 maximum",
            "lName.regex"=>"Last name begins with capital letter nad have 3 letters minimum, 30 maximum",
            "email.regex"=>"E-mail formats: milica@gmail.com or milica.jovanovic.88.18@ict.edu.rs",
            "subject.regex"=>"You have to write subject",
            "message.required"=>"Message has 10 words minimum"
        ];
    }
}
