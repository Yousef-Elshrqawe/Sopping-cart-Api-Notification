<?php

namespace App\Http\Resources;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    //  public static $wrap = null; // if you want to wrap the response with a key
    public function toArray($request)
    {

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();



        return
        [
            'User' =>

            [
               'id'     => $user->id,
               'name'   => $user->name,
               'email'  => $user->email,

            ],
            'Token' =>
            [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse
                (
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ],
        ];
    }

}
