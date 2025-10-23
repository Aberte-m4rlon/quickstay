<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\User;

class renterDashboardController extends Controller
{
  public function index(Request $request)
{
    $properties = Property::with('feedbacks')->get();
    $users = User::all(); // 👈 Add this line

    return view('renter.dashboard', compact('properties', 'users'));
}

}
