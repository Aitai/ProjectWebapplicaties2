<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @group Authenticatie
 */

class RegisterController extends Controller
{
    /**
     * Gebruiker registratie
     *
     * een gebruiker kan een account aanmaken bij ons. als dit request successvol is krijgt de gebruiker een validatie code in de mail.
     * De validatie code moet naar de validate endpoint gepost worden voor dat het account actief wordt.
     * de gebruiker krijgt hier de meest basis rol.
     *
     * @bodyParam email string required email address van de gebruiker. Example: user@project.local
     * @bodyParam password string required nieuw wachtwoord. Example: asdasd
     *
     * @response 200 "success": {
     *  "message": "Successful"
     * }
     *  @response 422 "error": {
     *  "code": 422,
     *  "message": "Invalid request."
     * }
     * @response 429  "error": {
     *  "code": 429,
     *  "message": "Too Many Attempts."
     * }
     */
    public function register(Request $request){
        $validated = $this->validateRequest($request);
        $user = new User($validated);
        $user->role = User::USER_ROLE_USER;
        if($user->save())
            return response(['message' => 'Successful']);

        return response(['message' => 'Invalid request'],422);
    }

    /**
     * Sctiveer gebruikers account
     *
     * na het ontvangen van de mail met de validate code.
     * Deze moet door de gebruiker worden ingevoerd om te bevestigen dat die zij/haar account is
     *
     * @bodyParam validationCode string required deze code heeft de gebruiker in de mail gekregen.
     *
     * @response 200 "success": {
     *  "message": "account gevalideerd"
     * }
     *  @response 422 "error": {
     *  "code": 422,
     *  "message": "Invalid request."
     * }
     * @response 429  "error": {
     *  "code": 429,
     *  "message": "Too Many Attempts."
     * }
     */
    public function verify(User $user, Request $request){
        if(!is_null($user) && $user->validation_code == $request->post('validation_code'))
            return response(['message' => 'Account gevalideerd']);

        return abort("Invalid request.",422);
    }

    private function validateRequest(Request $request)
    {
        return $this->validate($request, [
            'email' => 'required_without:password|email|unique:users', //email address must be unique
            'password' => 'required|string',
            'subscription_id' => 'uuid|exists:subscriptions,id', //created by user must already exist
            'created_by,updated_by,deleted_by' => 'uuid|exists:users,id', //created by user must already exist
        ]);
    }
}
