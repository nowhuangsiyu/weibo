<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //新建用户
    public function create()
    {
        return view('users/create');
    }

    //显示用户
    public function show(User $user)
    {
        return view('users/show', compact('user'));
    }

    //注册用户
    public function store(Request $request)
    {
        //进行信息过滤操作
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        //进行注册操作
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        //添加登陆态
        Auth::login($user);
        //添加注册成功的信息提示
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        //返回注册信息
        return redirect()->route('users.show', [$user]);
    }
}
