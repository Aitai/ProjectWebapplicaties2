<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @group User management
 *
 * APIs for managing users
 */
class UsersController extends Controller
{

    public function __construct()
    {
        \Illuminate\Support\Facades\Gate::authorize('admin');
    }

    /**
     * Summary of all users
     *
     * @urlParam page integer number of page.
     */
    public function index()
    {
        return User::paginate(Controller::PAGINATE_SIZE);
    }

    public function create(Request $request, User $user)
    {
        \Illuminate\Support\Facades\Gate::authorize('admin');
        $user = new User($this->validateRequest($request));

        if ($user->save())
            return response(['message' => 'Save Successfully'], 201);

        return response(['message' => 'Not saved'], 422);
    }

    /**
     * Summary of all deleted users
     */
    public function trashed()
    {
        return User::onlyTrashed()->paginate(Controller::PAGINATE_SIZE);
    }

    /**
     * Force delete a user
     */
    public function forceDelete(string $id)
    {
        if ((User::withTrashed()->findOrFail($id))->forceDelete())
            return response(['message' => 'Deleted Successfully'], 200);
    }

    public function restore(string $id){
        if ((User::withTrashed()->findOrFail($id))->restore())
            return response(['message' => 'Restored Successfully'], 200);

        return response(['message' => 'Deleted user not found'], 404);
    }

    private function validateRequest(Request $request)
    {
        return $this->validate($request, [
            'email' => 'required_without:password|email|unique:users', //email address must be unique
            'password' => 'required|string',
            'created_by,updated_by,deleted_by' => 'uuid|exists:users,id', //created by user must already exist
            'subscription_id' => 'uuid|exists:users,id', //created by user must already exist
            'role' => Rule::in([ //check for supported user roles
                User::USER_ROLE_ADMIN,
                User::USER_ROLE_USER,
                User::USER_ROLE_STATION
            ]),
        ]);
    }
}
