<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function show($id)
    {
        $property = Property::with(['feedbacks.user'])->findOrFail($id);
        return view('renter.properties.show', compact('property'));
    }

}
