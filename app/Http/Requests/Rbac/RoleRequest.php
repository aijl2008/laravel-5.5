<?php
namespace App\Http\Requests\Rbac;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest {
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
            'name' => 'required|max:45' ,
            'note' => 'required|max:45'
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
            'name' => (string) $this->name ,
            'note' => (string) $this->note
        ];
    }
}

