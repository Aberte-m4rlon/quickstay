<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\DB;

class PropertyApiController extends Controller
{
    // Geospatial Search API
    public function index(Request $req)
    {
        $lat = (float)$req->query('lat');
        $lng = (float)$req->query('lng');
        $radius = $req->query('radius', 5); // km

        $haversine = "(6371 * acos(cos(radians($lat)) 
                    * cos(radians(latitude)) 
                    * cos(radians(longitude) - radians($lng)) 
                    + sin(radians($lat)) * sin(radians(latitude))))";

        $properties = Property::select('*', DB::raw("$haversine AS distance"))
            ->where('is_verified', true)
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get();

        return response()->json($properties);
    }
}
