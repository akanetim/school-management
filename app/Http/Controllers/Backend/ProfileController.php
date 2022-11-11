<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function ProfileView(){
        $id = FacadesAuth::user()->id;
        $user = User::find($id);

        return view('backend.user.view_profile',compact('user'));
    }

    public function ProfileEdit(){
        $id = FacadesAuth::user()->id;
        $editData = User::find($id);

        return view('backend.user.edit_profile', compact( 'editData'));
    }

    public function profileStore(Request $request){
       $data = User::find(FacadesAuth::user()->id);
       $data->name = $request->name;
       $data->email = $request->email;
       $data->mobile = $request->mobile;
       $data->address = $request->address;
       $data->gender = $request->gender;

        if($request->file('image')){
            $file = $request->file('image');
            @unlink(public_path('upload/user_images/'.$data->image));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images/'),$filename);
            $data['image'] = $filename;

        }
        $data->save();

        $notification = array(
            'message' => 'User profile updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('profile.view')->with($notification);

    }

    public function PasswordView(){

        return view('backend.user.edit_password');
    }

    public function PasswordUpdate(Request $request){
        $validatedData = $request->validate([
            'oldpassword'=> 'required',
            'password'=> 'required|confirmed',

        ]);

        $hashedPassword = FacadesAuth::user()->password;
        if( Hash::check($request->oldpassword,$hashedPassword)){
            $user = User::find(FacadesAuth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            FacadesAuth::logout();
            return redirect()->route('login');
        }else{
            return redirect()->back();
        }
    }
}
