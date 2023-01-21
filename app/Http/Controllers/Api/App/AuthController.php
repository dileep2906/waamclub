<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use  HasApiTokens;

    public function createUser(Request $request)
    {
        // echo ($request);
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

            $user = Agent::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'enc_pass'  => $request->password,
                'agent_id' => 'Agents00123',
                // 'user_id' =>,
                'password'  => Hash::make($request->password),              
                'user_type' => 'AGENT'
            ]);

            return response()->json([
                'status' => "success",
                "statusCode" => "200",
                'message' => 'Agent Created Successfully',
            ], 200)->withHeaders([
                'token' => $user->createToken("APP_API_Token")->plainTextToken
                
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
            // $token = auth::user()->createToken($user->email . '_ADMIN_Token');
            $token = $user->createToken($user->id . 'APP_API_Token');
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

    public function generateOTP()
    {
        // $otp = mt_rand(1000, 9999);
        $otp        =   1111; //temp otp
        return $otp;
    }

    public function sendLoginOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|integer|min_digits:10',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'FAILED',
                'status_code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }
        $data =  $validator->validated();
        $otp = $this->generateOTP();
        $user = app_user::where('phone', $request->phone)->first();
        // add column registraioncompleted use. 0 for profile not completed
        // in case registraioncompleted==0 send 201
        // dd($user->phone);
        if ($user) {
            $user->otp = $otp;
            $user->otp_verified = 0;
            $user->otp_created_at   =   now();
            $user->update();
            // Registraion Not Completed
            if ($user->registration_completed == 0) {
                return response()->json(
                    [
                        'status' => TRUE,
                        'status_code' => 201,
                        'message' => 'complete user profile',
                        'data'      => $user
                    ],
                    201
                );
            } else {

                return response()->json(
                    [
                        'status' => TRUE,
                        'status_code' => 200,
                        'message' => 'Otp Sent',
                    ],
                    200
                );
            }
        } else {
            $user = new app_user();
            $user->phone = $data['phone'];
            $user->otp = $otp;
            $user->otp_verified = 0;
            $user->otp_created_at   =   now();
            $user->save();

            return response()->json(
                [
                    'status' => TRUE,
                    'status_code' => 201,
                    'message' => 'user Created',
                ],
                201
            );
        }
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|integer|min_digits:10',
            'otp' => 'required|integer|min_digits:4',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'FAILED',
                'status_code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }
        $user   = app_user::where(['phone' => $request->phone, 'otp' => $request->otp, 'otp_verified' => 0])->first();
        if ($user) {
            // $user->otp_verified = 1;
            $user->otp_verified_at   =   now();
            $token = $user->createToken($user->id . 'APP_API_Token');
            Auth::guard('api')->login($user);
            $user->save();
            return response()->json([
                'status'        => TRUE,
                'status_code'   => 200,
                'message'       => 'OTP Verified Successfully',
            ], 200)->withHeaders([
                'Token' => $token->plainTextToken,
            ]);
        } else {
            return response()->json([
                'status' => 'FAILED',
                'status_code' => 403,
                'errors' => 'invalid data to process with',
            ], 403);
        }
    }
}
