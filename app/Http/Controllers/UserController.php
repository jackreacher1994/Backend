<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Http\Requests\UserRequest;
use Response;
use Auth;
use App\Role;
use Gate;
use Validator;
use File;
use Session;

class UserController extends Controller
{   
    public function listUser(){
        $users = User::where('id', '!=', Auth::id())->orderBy('id', 'DESC')->get();
        foreach ($users as $user) {
            $user->roles = $user->roles;
        }
        return Response::json(['data' => $users]);
    }
    
    public function index(){
        if (Gate::denies('UserController.index')){
           abort(403);
        }
        $default_role_name = config('general.default_role');
        $roles = Role::where('name', '<>', $default_role_name)->get();
        $default_role = Role::where('name', '=', $default_role_name)->firstOrFail();
        return view('admin.pages.user', array('roles' => $roles, 'default_role' => $default_role, 'menuActive' => 'User'));
    }

    public function store(UserRequest $request){
        if (Gate::denies('UserController.store')){
           abort(403);
        }
        $user = new User();
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $role_ids = $request->role;
        foreach ($role_ids as $role_id) {
            $user->assignRole(Role::findOrFail($role_id));
        }
        
        return Response::json(['flash_message' => 'Đã thêm người dùng!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function show($id){
        if (Gate::denies('UserController.show')){
            abort(403);
        }
        $user = User::findOrFail($id);
        $user->roles = $user->roles;
        return Response::json($user);
    }

    public function update($id, UserRequest $request) {
      if (Gate::denies('UserController.update')) {
            abort(403);
      }
      if ($request->isMethod('patch'))  {
        $user = User::findOrFail($id);
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        if(isset($request->password)){
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $user->removeAllRole();
        $role_ids = $request->role;
        foreach ($role_ids as $role_id) {
            $user->assignRole(Role::findOrFail($role_id));
        }

        return Response::json(['flash_message' => 'Đã cập nhật thông tin người dùng!', 'message_level' => 'success', 'message_icon' => 'check']);
      } else {
        $user = User::findOrFail($id);
        $user->roles = $user->roles;
        return Response::json($user);
      }
    }

    public function destroy(UserRequest $request){
        if (Gate::denies('UserController.destroy')){
           abort(403);
        }
        $i = 0;
        if (is_string($request->ids)) {
            $user_ids = explode(' ', $request->ids);
            foreach ($user_ids as $user_id) {
                if ($user_id != NULL) {
                    if (Auth::user()->id == $user_id) {
                        $i = 0;
                        break;
                    }
                    else 
                        $i++;
                }
            }
        }

        if ($i > 0) {
            foreach ($user_ids as $user_id) {
                if ($user_id != NULL)
                    User::findOrFail($user_id)->delete();
            }
            return Response::json(['flash_message' => 'Đã xóa người dùng!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            return Response::json(['flash_message' => 'Bạn không thể xóa!', 'message_level' => 'danger', 'message_icon' => 'ban']);
        }
    }

    public function showProfile(){
        $roles = Auth::user()->roles;
        return view('admin.pages.profile', array('roles' => $roles, 'menuActive' => 'Profile'));
    }

    public function updateProfile(Request $request){
        $rules = array(
            'fullname' => 'required',
            'avatar' => 'image'
        );

        $messages = array(
            'fullname.required' => 'Vui lòng điền họ tên.',
            'avatar.image' => 'Tệp đã chọn không phải hình ảnh.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            $messages = $validator->messages();
            return redirect('profile')->withErrors($validator);
        } else {
            $user = Auth::user();
            $user->fullname = $request->fullname;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->bio = $request->bio;

            if(!empty($request->file('avatar'))){
                $filename = $request->file('avatar')->getClientOriginalName();
                $user->avatar = $filename;
                $request->file('avatar')->move('public/upload/avatar/', $filename);

                if(isset($request->current_avatar)){
                    $current_avatar = 'public/upload/avatar/'.$request->current_avatar;
                    if(File::exists($current_avatar)) {
                        File::delete($current_avatar);
                    }
                }
            }

            $user->save();
            
            return redirect('profile')->with(['flash_message' => 'Đã cập nhật hồ sơ!', 'message_level' => 'success', 'message_icon' => 'check']);
        }
    }

    public function showPassword(){
        return view('admin.pages.password', array('menuActive' => 'Password'));
    }

    public function updatePassword(Request $request){
        $rules = array(
            'password' => 'required|confirmed',
            'old_password' => 'required|old_password'
        );

        $messages = array(
            'old_password.required' => 'Vui lòng điền mật khẩu cũ.',
            'old_password.old_password' => 'Mật khẩu cũ không đúng.',
            'password.required' => 'Vui lòng điền mật khẩu mới.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            $messages = $validator->messages();
            return redirect('password')->withErrors($validator);
        } else {
            $user = Auth::user();
            $user->password = bcrypt($request->password);
            $user->save();
            
            if(Session::has('changePasswordMessage')){
                Session::forget('changePasswordMessage');
            }

            return redirect('password')->with(['flash_message' => 'Đã cập nhật mật khẩu!', 'message_level' => 'success', 'message_icon' => 'check']);
        }
    }
}
