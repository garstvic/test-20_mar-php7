<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\House;
use App\Http\Resources\House as HouseResource;

class HouseController extends Controller
{
    const PAGINATE = 5;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get houses
        $houses = House::orderBy('created_at', 'desc')->paginate(self::PAGINATE);
        
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

        if ($name = $request->input('name'))
        {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($bathrooms = $request->input('bathrooms'))
        {
            $query->where('bathrooms', $bathrooms);
        }

        if ($bedrooms = $request->input('bedrooms'))
        {
            $query->where('bedrooms', $bedrooms);
        }

        if ($storeys = $request->input('storeys'))
        {
            $query->where('storeys', $storeys);
        }

        if ($garages = $request->input('garages'))
        {
            $query->where('garages', $garages);
        }
        
        $priceStart = $request->input('price_start');
        $priceEnd = $request->input('price_end');
        if ($priceStart && $priceEnd)
        {
            $query->whereBetween('price', [$priceStart, $priceEnd]);
        }

        if ($priceStart && !$priceEnd)
        {
            $query->where('price', '>', $priceStart);
        }

        if (!$priceStart && $priceEnd)
        {
            $query->where('price', '<', $priceEnd);
        }
        
        return HouseResource::collection($query->paginate(self::PAGINATE));
    }
}
