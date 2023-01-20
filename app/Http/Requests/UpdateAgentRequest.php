<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgentRequest extends FormRequest
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
            'mobile'            =>'required',
            'whatsapp_number'   =>'required',
            'email'             =>'required',
            'home_address'      =>'required',
            'current_address'   =>'required',
            'nearest_hub'       =>'required',
            'landmark'          =>'required',
            'password'          =>'required',           
            'agent_id'          =>'required',
            'dob'               =>'required',
            'country'           =>'required',
            'state'             =>'required',
            'city'              =>'required',           
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
