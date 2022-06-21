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

    private function validateRequest(Request $request)
    {
        return $this->validate($request, [
            'email' => 'required_without:password|email|unique:users', //email address must be unique
            'password' => 'required|string',
        ]);
    }
}
