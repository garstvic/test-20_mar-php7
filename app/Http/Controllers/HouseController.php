<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\House;
use App\Http\Resources\House as HouseResource;

class HouseController extends Controller
{
    const PAGINATE = 25;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get houses
        $houses = House::paginate(self::PAGINATE);
        
        // Return collection of houses
        
        return HouseResource::collection($houses);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $house = House::findOrFail($id);
        
        return new HouseResource($house);
    }
    
    /**
     * Display the founded houses
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public function search(Request $request)
    {
        $house = new House();
        $query = $house->newQuery();

        if ($request->has('name'))
        {
            $query->where('name', 'like', "%{$request->input('name')}%");
        }

        if ($request->has('bathrooms'))
        {
            $query->where('bathrooms', $request->input('bathrooms'));
        }

        if ($request->has('bedrooms'))
        {
            $query->where('bedrooms', $request->input('bedrooms'));
        }

        if ($request->has('storeys'))
        {
            $query->where('storeys', $request->input('storeys'));
        }

        if ($request->has('garages'))
        {
            $query->where('garages', $request->input('garages'));
        }

        if ($request->has('price_start') && $request->has('price_end'))
        {
            $query->whereBetween('price', [$request->input('price_start'), $request->input('price_end')]);
        }

        if ($request->has('price_start') && !$request->has('price_end'))
        {
            $query->where('price', '>', $request->input('price_start'));
        }

        if (!$request->has('price_start') && $request->has('price_end'))
        {
            $query->where('price', '<', $request->input('price_end'));
        }

        return HouseResource::collection($query->get());
    }
}
