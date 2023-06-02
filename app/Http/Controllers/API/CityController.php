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
            ->when($request->has('state'), function ($query) use ($request) {
                return $query->where('state_id', $request->state);
            })
            ->when($request->has('search'), function ($query) use ($request) {
                return $query->where('cities.title', 'like', '%' . $request->search . '%');
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
