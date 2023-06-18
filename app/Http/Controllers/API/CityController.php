<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends BaseController
{
    public function index(Request $request)
    {
        $query = City::query()
            ->with('state')
            ->orderBy('title', 'asc')
            ->when($request->has('state_id'), function ($query) use ($request) {
                return $query->where('state_id', $request->state_id);
            })
            ->when($request->has('name'), function ($query) use ($request) {
                return $query->where('cities.title', 'like', '%' . $request->name . '%');
            });

        ($request->has('page'))  ? $data = $query->paginate(10) : $data = $query->get();

        return $this->sendResponse($data);
    }

    public function show($id)
    {
        $item = City::findOrFail($id);

        return $this->sendResponse($item);
    }
}
