<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Maintenance;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/**
 * @group Maintenance management
 *
 * APIs for managing maintenances
 */

class SubscriptionController extends Controller
{
    public function index()
    {
        return Subscription::paginate(Controller::PAGINATE_SIZE);
    }

    public function show(string $id)
    {
        $device = Subscription::findOrFail($id);
        return $device;
    }

    public function update(Request $request, string $id)
    {
        $device = Subscription::findOrFail($id);

        $request->request->add(['id' => $id]);

        $device->update($this->validateRequest($request));
        return response('Updated Successfully', 200);
    }

    public function destroy(string $id)
    {
        $device = Subscription::findOrFail($id);

        if ($device->delete())
            return response(['message' => 'Deleted Successfully'], 200);
    }

    private function validateRequest(Request $request)
    {
        return $this->validate($request, [
            'name' => 'required|string|max:255',
            'times_day' => 'required|integer',
            'times_hour' => 'required|integer',
        ]);
    }
}
