<?php

namespace App\Http\Controllers;

use App\Http\Requests\storePostRequest;
use App\Http\Requests\updateRequest;
use App\Models\User;
use Illuminate\Http\Request;

use App\Repositories\Interfaces\UserRepositoryInterface;

class userController extends Controller
{
    private $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /*
    This function is to go to edit blade
     */

    public function edit($id)
    {
        try {
            $data = $this->userRepository->edit($id);
            return view('user/edit', compact('data'));
        } catch (\Exception $e) {
            return back()->with('errorMsg', $e->getMessage());
        }
    }
    /* This function updating the user details */
    public function update(storePostRequest $request, $id)
    {
        try {
            $updated = $this->userRepository->update($request->all(), $id);
            if ($updated) {
                return back()->with('successMsg', "updated successfully");
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
            $data = $this->userRepository->changePassword($id);
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
            $updatedata = $this->userRepository->updatePassword($request->all(), $id);
            if ($updatedata) {
                return back()->with('successMsg', "password changed successfully");
            } else {
                return back()->with('errorMsg', "wrong password");
            }
        } catch (\Exception $e) {
            return back()->with('errorMsg', $e->getMessage());
        }
    }
}
