<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class AuthController extends Controller
{
    // Register function
    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required','confirmed', Password::defaults()]
        ]);

        if($validator->fails()) {
            return ApiResponse::sendResponse(422, $validator->errors()->first(), $validator->errors());
        }

        $request['password'] = bcrypt($request->password);

        $user = User::create($request->all());

        $data['token'] = $user->createToken('api_project')->plainTextToken;
        $data['name'] = $user->name;
        $data['email'] = $user->email;

        return ApiResponse::sendResponse(201, 'User created successfully!', $data);

    }// end of register function


    // Login function
    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return ApiResponse::sendResponse(422, $validator->errors()->first(), $validator->errors());
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            // if statement to ignore creattoken error
            if ($user instanceof \App\Models\User) {

                $data['token'] = $user->createToken('api_project')->plainTextToken;
                $data['name'] = $user->name;
                $data['email'] = $user->email;

                return ApiResponse::sendResponse(200, 'User logged in successfully!', $data);

            }

        }

        return ApiResponse::sendResponse(401, 'Credentials are not correct!', []);

    }// end of login fucntion

    // logout function
    public function logout(Request $request) {

        // dd($request->user()->name);

        $request->user()->currentAccessToken()->delete();

        return ApiResponse::sendResponse(200, 'User logged out successfully!', []);

    }


}
