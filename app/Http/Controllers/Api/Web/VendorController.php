<?php

namespace App\Http\Controllers\Api\Web;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function index()
    {
        
        $Vendor = User::where('user_type' , '=' , 'Vendor')->get();

        if (count($Vendor)) {
            return response()->json([
                'status' => 'SUCCESS',
                'status_code' => 200,
                'data' => $Vendor
            ]);
        } else {
            return response()->json([
                'status' => 'FAILED',
                'status_code' => 404,
                'message' => "No Records Found"
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */ public function store(Request $request)
    {
        $validator = Validator::make(
            request()->all(),
            [
                'name' => 'required',
                'father_name' => 'required',
                'mother_name' => 'required',
                'email' => 'required',
                'mobile' => 'required',
                'whatsapp_number' => 'required',
                'dob' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'home_address' => 'required',
                'current_address' => 'required',
                'pan_number' => 'required',
                'pan_image' => 'required',
                'bank_account' => 'required',
                'ifcs_code' => 'required',
                'branch' => 'required',
                'bank_holder_name' => 'required',
                'upi_number' => 'required',
                'adhar_number' => 'required',
                'profile_image' => 'required',
                'signature_image' => 'required',
            ]
        );

       
        if($validator->fails())
        {
            return response()->json([
                    'status' => 422,
                    'error' => $validator->errors(),
                ],422);           
        }
        
        $validatedData      =   $validator->validated();
        // if ($request->hasFile('logo')) {
        //     $uploadedFileName = $this->uploadFile($request->file('logo'), 'images/company/');
        //     $validatedData['logo']      =   $this->filePath;
        // }
        $validatedData['password']  = Hash::make($request->password);
        $validatedData['enc_pass'] = $request->password;
        $validatedData['user_type'] = "Vendor";
        $NewVender        =   User::create($validatedData);
        return response()->json(
            [
                'status' => 'SUCCESS',
                'status_code' => 200,
                'message' => 'Vender Details Inserted Successfully',
                'data'  => ['id' => $NewVender->id],
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $vendor)
    {
        return response()->json(['status' => 'SUCCESS', 'status_code' => 200, 'data' => $vendor]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $vendor)
    {
        $validatedData      =   $request->validated();

        $image_path     =   '';
        // if ($request->hasfile('logo')) {
        //     $image      = $request->file('logo');
        //     $folder     = public_path('assets/images/company');
        //     $name       = Str::random(30) . '_' . time();
        //     $filePath   = $folder . $name . '.' . $image->getClientOriginalExtension();
        //     $this->uploadImage($image, $folder, 'public', $name);
        //     $image_path = 'assets/images/company/' . $name . '.' . $image->getClientOriginalExtension();
        //     $validatedData['logo'] = $image_path;
        // }
        $vendor->update(array_filter($validatedData));
        return response()->json([
            'status' => 'SUCCESS',
            'status_code' => 200,
            'message' => 'Vendor Details updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $vendor)
    {
        if ($vendor->delete()) {
            return response()->json(['status' => 'SUCCESS', 'status_code' => 200, 'message' => 'Company Details Deleted']);
        } else {
            return response()->json(['status' => 'FAILED', 'status_code' => 400, 'message' => 'Something Went Wrong'], 400);
        }
    }}
