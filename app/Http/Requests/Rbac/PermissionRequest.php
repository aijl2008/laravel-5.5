<?php
namespace App\Http\Requests\Rbac;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize () {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules () {
        return [
            'uri' => 'required|max:100'
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages () {
        return [ ];
    }

    /**
     * Return the fields and values to create a new post from
     */
    public function data () {
        return [
            'role_id' => (integer) $this->route ( 'role' ) ,
            'uri' => (string) $this->uri ,
            'route' => (string) $this->route
        ];
    }
}

