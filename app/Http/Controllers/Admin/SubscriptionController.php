<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscription;
use Illuminate\Http\Request;

/**
 * @group Maintenance management
 *
 * APIs for managing maintenances
 */
class SubscriptionController extends Controller
{
    public function __construct()
    {
       // \Illuminate\Support\Facades\Gate::authorize('admin');
    }

    ///Admin functions
    public function index()
    {
        return Subscription::paginate(Controller::PAGINATE_SIZE);
    }
    /**
     * Subscriptie aan maken
     *
     * @bodyParam name string required email address van de gebruiker. Example: Beste
     * @bodyParam times_day integer nieuw wachtwoord. Example: 10
     * @bodyParam times_hour integer nieuw wachtwoord. Example: 1
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
    public function create(\Illuminate\Http\Request $request)
    {
        if (Subscription::updateOrCreate($this->validateRequest($request)))
            return response('Save Successfully', 201);

        return response('Not saved', 422);
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

    public function trashed()
    {
        return Subscription::onlyTrashed()->paginate(Controller::PAGINATE_SIZE);
    }

    public function forceDelete(string $id)
    {
        if ((Subscription::findOrFail($id))->forceDelete())
            return response(['message' => 'Deleted Successfully'], 200);
    }
    public function restore(string $id){
        if ((Subscription::findOrFail($id))->restore())
            return response(['message' => 'Restore successfully'], 200);
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
