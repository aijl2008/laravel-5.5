<?php
namespace App\Http\Requests\Rbac;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {
    public function authorize () {
        return true;
    }

    public function rules () {
        return [
            'name' => 'required' ,
            'email' => 'required'
        ];
    }


    public function fillData () {
        $fillData = [
            'name' => (string) $this->name ,
            'email' => (string) $this->email ,
        ];
        if ( $this->password ) {
            $fillData[ 'password' ] = bcrypt ( $this->password );
        }
        return $fillData;
    }
}
