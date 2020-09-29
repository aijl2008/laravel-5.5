<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\My\ProfileRequest;
use App\Models\Rbac\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        if (!empty(config('rbac.oauth'))) {
            return redirect(config('rbac.oauth.server'));
        }
        $User = (new class extends User
        {
            function getPasswordAttribute()
            {
                $this->attributes['password'] = '';
            }
        })->findorfail(Auth::user()->getAuthIdentifier());
        return view('my.profile.edit', [
            'model' => $User
        ]);
    }

    public function update(ProfileRequest $request)
    {
        $User = (new  User ())->findorfail(Auth::user()->getAuthIdentifier());
        $User->fill($request->FillData());
        $User->save();
        return redirect()->back()->with('success', '修改成功');
    }
}
