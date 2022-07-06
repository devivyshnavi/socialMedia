<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Requests\storePostRequest;
use App\Http\Requests\updateRequest;

class UserApiController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->userRepository = $userRepository;
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "firstname" => 'required|string',
            "lastname" => "string",
            "email" => "required|email|unique:users",
            "password" => "required|min:8",
            "confirm" => "required|same:password",

        ]);
        if ($validator->fails()) {
            return response()->json([$validator->errors(), "status" => "false"]);
        } else {
            $user = User::insert([
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "email" => $request->email,
                "password" => Hash::make($request->password)
            ]);
            return response()->json(['status' => 'true', 'message' => 'User registered'], 200);
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors(), "status" => "false"]);
        } else {
            if (!$token = auth()->guard('api')->attempt($validator->validated())) {
                return response()->json(['status' => 'false', 'error' => 'Unauthorized'], 401);
            }

            return response()->json(['status' => 'true', 'access_token' => $token], 200);
        }
    }
    public function getDetails($id)
    {
        try {
            $data = $this->userRepository->edit($id);
            return response()->json(["data" => $data, "status" => "true"], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "false", "error" => $e]);
        }
    }
    public function updateUser(storePostRequest $request, $id)
    {
        try {
            $updated = $this->userRepository->update($request->all(), $id);
            if ($updated) {
                return response()->json(["message" => "updated", "status" => "true"], 200);
            }
        } catch (\Exception $e) {
            return response()->json(["status" => "false", "error" => $e]);
        }
    }
    public function updatePassword(updateRequest $request, $id)
    {
        try {
            $updatedata = $this->userRepository->updatePassword($request->all(), $id);
            if ($updatedata) {
                return response()->json(["message" => "password changed", "status" => "true"], 200);
            } else {
                return response()->json(["message" => $updatedata, "status" => "false"], 200);
            }
        } catch (\Exception $e) {
            return response()->json(["status" => "false", "error" => $e]);
        }
    }
}
