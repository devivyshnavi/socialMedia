<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    /* to view edit blade */
    public function edit($id)
    {
        return User::find($id);
    }
    /* to update user details */
    public function update($data, $id)
    {
        $user = User::find($id);
        /* If the image wants to change */
        if (array_key_exists('image', $data)) {
            $image = $data['image'];
            $image_name = rand() . "_" . $image->getClientOriginalName();
            $image->move(public_path('/uploads'), $image_name);
            $user->firstname = $data['firstname'];
            $user->status = $data['status'];
            $user->lastname = $data['lastname'];
            $user->avatar = '/uploads/' . $image_name;
        } else {
            $user->firstname = $data['firstname'];
            $user->status = $data['status'];
            $user->lastname = $data['lastname'];
        }
        return $user->save();
    }
    /* to go the change password blade */

    public function changePassword($id)
    {
        return User::find($id);
    }

    /* to update password  */

    public function updatePassword($data, $id)
    {
        $user = User::find($id);
        $dbpassword = $user->password;
        $oldpassword = $data['oldpassword'];
        $newpassword = $data['newpassword'];
        $confirmpassword = $data['confirmpassword'];
        if ($newpassword == $confirmpassword) {
            if (Hash::check($oldpassword, $dbpassword)) {
                return  User::where('id', $id)->update([
                    "password" => Hash::make($newpassword)
                ]);
            }
        }
    }
}
