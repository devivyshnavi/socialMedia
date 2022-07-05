<?php

namespace App\Http\Controllers;

use App\Http\Requests\storePostRequest;
use App\Http\Requests\updateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    /*
    This function is to go to edit blade
     */

    public function edit($id)
    {
        try {
            $data = User::find($id);
            return view('user/edit', compact('data'));
        } catch (\Exception $e) {
            return back()->with('errorMsg', $e->getMessage());
        }
    }
    /* This function updating the user details */
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
            return back()->with('errorMsg', $e->getMessage());
        }
    }
    /*
    This function is to go to changePassword blade
     */
    public function changePassword($id)
    {
        try {
            $data = User::find($id);
            return view('user/changePassword', compact('data'));
        } catch (\Exception $e) {
            return back()->with('errorMsg', $e->getMessage());
        }
    }
    /*

     This function is to update password
*/
    public function updatePassword(updateRequest $request, $id)
    {
        try {
            $data = User::find($id);
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
            return back()->with('errorMsg', $e->getMessage());
        }
    }
}
