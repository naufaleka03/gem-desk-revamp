<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AssetManagementController extends Controller
{       
    public function index()
    {
        return view('assetManagement.index');
    }
}