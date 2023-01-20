<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'              =>'required',
            'father_name'       =>'required',
            'mother_name'       =>'required',
            'email'             =>'required',
            'password'          =>'required',
            'mobile'            =>'required',
            'whatsapp_number'   =>'required',
            'dob'               =>'required',
            'country'           =>'required',
            'state'             =>'required',
            'city'              =>'required',
            'home_address'      =>'required',
            'current_address'   =>'required',
            'pan_number'        =>'required',
            'pan_image'         =>'required',
            'bank_account'      =>'required',
            'ifcs_code'         =>'required',
            'branch'            =>'required',
            'bank_holder_name'  =>'required',
            'upi_number'        =>'required',
            'adhar_number'      =>'required',
            'profile_image'     =>'required',
            'signature_image'   =>'required',
        ];
    }
}
