<?php

namespace App\Http\Controllers;

use App\Models\Granja;
use Illuminate\Http\Request;

class GranjaController extends Controller
{
    public function index()
    {
        $granjas = Granja::all();
        return view('granjas.index', compact('granjas'));
    }
}