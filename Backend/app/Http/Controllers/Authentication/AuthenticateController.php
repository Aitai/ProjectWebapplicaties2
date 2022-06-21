<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function abort;
use function config;

/**
 * @group Authentication
 */
class AuthenticateController extends Controller
{

    /**
     * Basic login
     *
     * This is used for first time authentication.
     *
     * @bodyParam email string required E-mail of the user. Example: development@dxmusic.nl
     * @bodyParam password string required Password of the user. Example: password
     *
     * @response 200 {
     *  "token": "String"
     * }
     * @response 401 "error": {
     *  "code": 401,
     *  "message": "Invalid credentials."
     * }
     **/
    public function basic(Request $request)
    {
        try {
            $user = User::where('email', $request->post('email'))->firstOrFail();
            //validate password
            if (Hash::check($request->get('password'), $user->password)) {
                return ['token' =>  AuthenticateController::generateNewJWTToken($user)];
            }
            abort(401, "Invalid credentials");
        } catch (ModelNotFoundException $e){
            abort(401, "Invalid credentials");
        }
    }

    /**
     * Renew token
     *
     * With this endpoint you can request a new token, the current one should be valid.
     * @authenticated
     *
     * @response {
     *  "token": "String"
     * }
     * @response 401 "error": {
     *  "code": 401,
     *  "message": "Unauthorized."
     * }
     **/
    public function jwt()
    {
        return ['token' => AuthenticateController::generateNewJWTToken(Auth::user())];
    }

    static function generateNewJWTToken($user): string
    {
        //load defualt payload
        $payload = config('jwt.payload');

        //add payload options
        $payload['aud'] = 'hanze.nl/v1/';
        $payload['iat'] = time();
        $payload['exp'] = time() + 604800;// een week
        $payload['id'] = $user->id;
        $payload['role'] = $user->role;
        $payload['email'] = $user->email;

        return JWT::encode(
            $payload,
            config('jwt.key'),
            config('jwt.alg')
        );
    }
}
