<?php
namespace App\Http\Requests\Rbac;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest {
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
            'name' => 'required|max:100' ,
            'url' => '|max:200' ,
            'ico' => '|max:200' ,
            'target' => '|max:255' ,
            'order_no' => '|max:64' ,
            'status' => '|max:2'
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
            'url' => (string) $this->url ,
            'parent_id' => (int) $this->route ( 'parent' ) ,
            'ico' => (string) $this->ico ,
            'target' => (string) $this->target ,
            'order_no' => (int) $this->order_no ,
            'status' => (int) $this->status
        ];
    }
}

