<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Activity;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        if (hasPermission('location_view_all')) {
            $locations = Location::with('user')->latest()->get();
        } else {
            $locations = Location::with('user')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        return view('locations.index', compact('locations'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        if (!hasPermission('location_add')) {
            return response()->view('errors.no-access');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name',
        ]);

        $location = Location::create([
            'user_id' => Auth::id(),
            'name'    => $request->name,
        ]);

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'locations',
            'table_id'    => $location->id,
            'operation'   => 'create',
            'description' => 'Location "' . $location->name . '" created',
        ]);

        return redirect()->route('locations.index')
            ->with('success', 'Location created successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        if (!hasPermission('location_edit')) {
            return response()->view('errors.no-access');
        }

        if (hasPermission('location_view_all')) {
            $locations = Location::with('user')->latest()->get();
            $editLocation = Location::findOrFail($id);
        } else {
            $locations = Location::with('user')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();

            $editLocation = Location::where('user_id', Auth::id())
                ->findOrFail($id);
        }

        return view('locations.index', compact('locations', 'editLocation'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        if (!hasPermission('location_edit')) {
            return response()->view('errors.no-access');
        }

        $request->validate([
            'name' => ['required','string','max:255',Rule::unique('locations', 'name')->ignore($id),],
        ]);

        if (hasPermission('location_view_all')) {
            $location = Location::findOrFail($id);
        } else {
            $location = Location::where('user_id', Auth::id())
                ->findOrFail($id);
        }

        $location->update([
            'name' => $request->name,
        ]);

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'locations',
            'table_id'    => $location->id,
            'operation'   => 'update',
            'description' => 'Location "' . $location->name . '" updated',
        ]);

        return redirect()->route('locations.index')
            ->with('success', 'Location updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        if (!hasPermission('location_delete')) {
            return response()->view('errors.no-access');
        }

        if (hasPermission('location_view_all')) {
            $location = Location::findOrFail($id);
        } else {
            $location = Location::where('user_id', Auth::id())
                ->findOrFail($id);
        }

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'locations',
            'table_id'    => $location->id,
            'operation'   => 'delete',
            'description' => 'Location "' . $location->name . '" deleted',
        ]);

        $location->delete();

        return redirect()->route('locations.index')
            ->with('success', 'Location deleted successfully');
    }
}