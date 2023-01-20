<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class VenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Franchise = User::where('user_type' , '=' , 'Vender')->get();

        if (count($Franchise)) {
            return response()->json([
                'status' => 'SUCCESS',
                'status_code' => 200,
                'data' => $Franchise
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        $validatedData['user_type'] = "Vender";
        $NewFranchise        =   User::create($validatedData);
        return response()->json(
            [
                'status' => 'SUCCESS',
                'status_code' => 200,
                'message' => 'Vendor Details Inserted Successfully',
                'data'  => ['id' => $NewFranchise->id],
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Franchise = User::where('user_type' , '=' , 'Vender')->where('id' , $id)->get();

        if (count($Franchise)) {
            return response()->json([
                'status' => 'SUCCESS',
                'status_code' => 200,
                'data' => $Franchise
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
