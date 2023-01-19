<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    use  HasApiTokens;

    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => ['required' , Password::default()]

            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'enc_pass'  => $request->password,
                'password'  => Hash::make($request->password),              
                'user_type' => 'ADMIN'
            ]);

            return response()->json([
                'status' => "success",
                "statusCode" => "200",
                'message' => 'User Created Successfully',
            ], 200)->withHeaders([
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {

        $validater = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => ['required', Password::defaults()],

        ]);

        if ($validater->fails()) {
            return response()->json([
                'status'        =>  'FAILED',
                'status_code'   =>  '400',
                'message'       =>  'INVALID REQUEST',
                'errors'        =>  $validater->errors()
            ], 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            auth::user()->tokens()->delete();
            $token = auth::user()->createToken($user->email . '_ADMIN_Token');
            // $user->syncRoles($user->user_type);
            $user->getAllPermissions();

            return response()->json([
                'status' => 'SUCCESS',
                'status_code'   =>  '200',

                'data' => ['user'  => $user,]
            ])->withHeaders([
                'Token' => $token->plainTextToken,
            ]);
        } else {
            return response()->json([
                'status' => 'FAILED',
                'status_code'   =>  '401',
                'message' => 'Invalid Credentials',
            ], 401);
        }
    }


    public function logout(Request $request)
    {
        $user = auth('sanctum')->user();
        if ($user) {
            $user->currentAccessToken()->delete();
            return response()->json([
                'status' => 'SUCCESS',
                'status_code' => 200,
                'message' => "Successfully Logged Out"
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "Something Went Wrong"
            ], 400);
        }
    }
}
