<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // Авторизация
    public function getLogin(Request $request)
    {
        // Поиск пользователя в базе
        $user = User::where('username', $request->username)->firstOrFail();
        // Проверка введен ли верный пароль
        if (app('hash')->check($request->password, $user->password)) {
            return response()->json(['logged' => true, 'user' => $user]);
        }
        return response()->json(['logged' => false]);
    }

    // Добавление пользователя
    public function postUserAdd(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => app('hash')->make($request->password)
        ]);
        return response()->json(['user' => $user]);
    }
}
