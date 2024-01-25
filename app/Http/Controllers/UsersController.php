<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TodoJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Exception;



class UsersController extends Controller
{

    public function changeRole(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }

        DB::delete("delete from model_has_roles  where  model_id=? ", [$request->user_id]);
        if ($request->role_id != "-1") {
            $user = User::find($request->user_id);
            $user->assignRole($request->role_id);

            return response()->json([
                "status" => true,
            ]);
        } else {
            return response()->json([
                "status" => true,
            ]);
        }
    }
    public function edit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required',
            // 'email' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->input('user_id'),
            'department' => 'required',
            'designation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }

        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->designation = $request->designation;
        $user->department_id = $request->department;
        $user->save();

        return response()->json([
            "status" => true,
        ]);
    }


    public function profileEdit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required',
            //  'email' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->input('user_id'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }

        $user = User::find($request->user_id);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password != null) {
            $user->password = Hash::make($request->password);
        }


        $user->save();

        return response()->json([
            "status" => true,
        ]);
    }



    public function profileEditImg(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }


        $user = User::find($request->user_id);



        if ($request->hasFile('image')) {

            $file = $request->only('image')['image'];
            $fileArray = array('image' => $file);
            $rules = array(
                'image' => 'mimes:jpg,png,jpeg,webp|required|max:500000'
            );
            $validator = Validator::make($fileArray, $rules);
            if ($validator->fails()) {
                // return response()->json($this->failedValidation($validator), 400);
                // return response()->json(['errors' => $validator->errors()], 400);
                return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
            } else {
                $uniqueFileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $fileName = date('Y') . "/" . date("m") . "/" . date("d") . "/" . $uniqueFileName;
                try {
                    if (!Storage::disk('public')->has('users/' . date('Y') . "/" . date("m") . "/" . date("d") . "/")) {
                        Storage::disk('public')->makeDirectory('users/' . date('Y') . "/" . date("m") . "/" . date("d") . "/");
                    }
                    Image::make($file)->resize(512, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path('app/public/users/' . $fileName));

                    $user->image = $fileName;
                } catch (Exception $r) {
                    return response()->json([
                        'status' => 500,
                        'message' => $r,
                    ]);
                }
            }
        }



        $user->save();

        return response()->json([
            "status" => true,
            "image" => $user->buildImage(),
        ]);
    }
}
