<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Http\Requests\Authorization\RegisterFormRequest;
use App\Http\Requests\Authorization\LoginFormRequest;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use App\Models\User;

class AuthorizationController extends Controller
{
    public function register(RegisterFormRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->assignRole('user');

        return $this->response->array([
            'status_code' => 201,
            'message' => $user
        ]);
    }

    public function login(LoginFormRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return $this->response->errorBadRequest('You cannot sign with those credentials');
        }

        if (!Auth::user()->confirmed) {
            return $this->response->errorUnauthorized();
        }

        $token = Auth::user()->createToken(config('app.name'));
        $token->token->expires_at = $request->remember_me ?
            Carbon::now()->addMonth() :
            Carbon::now()->addDay();

        $token->token->save();
        $user = Auth::user();
        $user['roles'] = Auth::user()->roles;
        return $this->response->array([
            'status_code' => 200,
            'message' => 'User successfully login',
            'data' => $user,
            'token_type' => 'Bearer',
            'token' => $token->accessToken,
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return $this->response->array([
            'status_code' => 200,
            'message' => 'User successfully logout'
        ]);
    }
}
