<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of all countries.
     */
    public function index(): string
    {
        return Country::all()->toJson();
    }


    /**
     * Display the specified country.
     */
    public function show(Country $country): string
    {
        return $country->toJson();
    }
}
