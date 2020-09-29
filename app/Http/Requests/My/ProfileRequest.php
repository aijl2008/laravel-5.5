<?php
namespace App\Http\Requests\My;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest {
    public function authorize () {
        return true;
    }

    public function rules () {
        return [
            'name' => 'required'
        ];
    }


    public function fillData () {
        $fillData = [
            'name' => $this->name ,
        ];
        if ( $this->password ) {
            $fillData[ 'password' ] = bcrypt ( $this->password );
        }
        return $fillData;
    }
}
