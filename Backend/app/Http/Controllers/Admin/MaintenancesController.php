<?php

namespace App\Http\Controllers\Admin;

use App\Models\Device;
use App\Models\Maintenance;

/**
 * @group Maintenance management
 *
 * APIs for managing maintenances
 */
class MaintenancesController extends Controller
{
    public function __construct()
    {
        \Illuminate\Support\Facades\Gate::authorize('admin');
    }

    ///Admin functions
    public function index()
    {
        return Maintenance::paginate(Controller::PAGINATE_SIZE);
    }

    public function trashed()
    {
        return Maintenance::onlyTrashed()->paginate(Controller::PAGINATE_SIZE);
    }

    public function forceDelete(string $id)
    {
        if ((Maintenance::findOrFail($id))->forceDelete())
            return response(['message' => 'Deleted Successfully'], 200);
    }
    public function restore(string $id){
        if ((Maintenance::findOrFail($id))->restore())
            return response(['message' => 'Restore successfully'], 200);
    }
}
