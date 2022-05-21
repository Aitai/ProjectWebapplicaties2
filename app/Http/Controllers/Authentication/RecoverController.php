<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;

/**
 * @group Authenticatie
 */
class RecoverController extends Controller
{
    /**
     * Wachtwoord resetten
     *
     * Je kan het process voor het aanvragen van een wachtwoord starten door hier een email address te posten.
     * Na het succesvol de response is altijd 200 ook als het email address niet bestaat
     *
     * @bodyParam email string required van welke gebruiker moet het wachtwoord gereset worden.
     *
     * @response 200 "success": {
     *  "token": "String"
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
    public function recoverPassword(){}

    /**
     * Nieuw wachtwoord instellen
     *
     * na het ontvangen van de mail met de validate code kan de gebruiker deze en het nieuwe wachtwoord na dit endpoint posten
     *
     * @bodyParam validationCode string required deze code heeft de gebruiker in de mail gekregen.
     * @bodyParam password string required nieuw wachtwoord.
     * @bodyParam passwordConfirm string required nieuw wachtwoord bevestiging.
     *
     * @response 200 "success": {
     *  "token": "String"
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
    public function createNewPassword(){}
}
