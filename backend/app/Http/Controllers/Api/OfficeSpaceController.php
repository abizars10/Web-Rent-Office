<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OfficeSpaceResource;
use App\Models\OfficeSpace;
use Illuminate\Http\Request;

class OfficeSpaceController extends Controller
{
    public function index()
    {
        // $officeSpaces= OfficeSpace::with(['city'])->get();
        $officeSpaces = OfficeSpace::with(['city', 'photos', 'benefits'])->withCount('city')->get();
        return OfficeSpaceResource::collection($officeSpaces);
    }

    public function show(OfficeSpace $officeSpace) //model binding
    {
        $officeSpace->load(['city', 'photos', 'benefits']);
        return new OfficeSpaceResource($officeSpace);
    }
}
