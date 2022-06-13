<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

/**
 * @group User management
 *
 * API's for managing users
 */
class UsersController extends Controller
{

    /**
     * Show my user profile
     */
    public function view()
    {
        return Auth::user();
    }

    private function validateRequest(Request $request)
    {
        return $this->validate($request, [
            'email' => 'required_without:password|email|unique:users', //email address must be unique
            'password' => 'required|string',
            'created_by,updated_by,deleted_by' => 'uuid|exists:users,id', //created by user must already exist
            'role' => Rule::in([ //check for supported user roles
                User::USER_ROLE_ADMIN,
                User::USER_ROLE_USER,
                User::USER_ROLE_STATION
            ]),
        ]);
    }
}
