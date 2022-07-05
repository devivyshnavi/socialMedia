<?php

namespace App\Http\Controllers;

use App\Http\Requests\storePostRequest;
use App\Http\Requests\updateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function edit($id)
    {
        try {
            $data = User::find($id);
            return view('user/edit', compact('data'));
        } catch (\Exception $e) {
            return $e;
        }
    }
    public function update(storePostRequest $request, $id)
    {

        try {
            $user = User::find($id);
            $user->firstname = $request->firstname;
            $user->status = $request->status;
            $user->lastname = $request->lastname;

            if ($user->save()) {
                return back()->with('successMsg', "Updated successfully");
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
    public function changepassword($id)
    {
        try {
            $data = User::find($id);
            return view('user/changePassword', compact('data'));
        } catch (\Exception $e) {
            return $e;
        }
    }
    public function updatepassword(updateRequest $request, $id)
    {
        $data = User::find($id);
        try {
            $dbpassword = $data->password;
            $oldpassword = $request->oldpassword;
            $newpassword = $request->newpassword;
            $confirmpassword = $request->confirmpassword;
            if ($newpassword == $confirmpassword) {
                if (Hash::check($oldpassword, $dbpassword)) {
                    $updatedata = User::where('id', $id)->update([
                        "password" => Hash::make($newpassword)
                    ]);
                    if ($updatedata) {
                        return back()->with('successMsg', "password changed successfully");
                    }
                } else {
                    return back()->with('errorMsg', "Wrong password");
                }
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
}
