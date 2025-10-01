<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller {
    public function index() {
        $cites     = Location::city()->orderBy('id', 'DESC')->searchable(['name'])->paginate(getPaginate());
        $pageTitle = "Manage City";
        return view('admin.location.city', compact('pageTitle', 'cites'));
    }

    public function save(Request $request, $id = 0) {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        if ($id) {
            $city    = Location::findOrFail($id);
            $message = "City updated successfully";
        } else {
            $city    = new Location();
            $message = "City added successfully";
        }

        $city->name = $request->name;
        $city->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function location() {
        $locations = Location::location()->orderBy('id', 'DESC')->with('town')->searchable(['name', 'town:name'])->paginate(getPaginate());
        $pageTitle = "Manage Location";
        $cites     = Location::city()->active()->orderBy('id', 'DESC')->get();
        return view('admin.location.index', compact('pageTitle', 'locations', 'cites'));
    }

    public function locationSave(Request $request, $id = 0) {
        $request->validate([
            'name' => 'required|max:255',
            'city' => 'required|integer',
        ]);

        $city = Location::city()->active()->findOrFail($request->city);

        if ($id) {
            $location = Location::findOrFail($id);
            $message  = "Location updated successfully";
        } else {
            $location = new Location();
            $message  = "Location added successfully";
        }

        $location->name      = $request->name;
        $location->parent_id = $city->id;
        $location->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function status($id) {
        return Location::changeStatus($id);
    }
}
