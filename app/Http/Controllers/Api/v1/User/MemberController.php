<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function show(Request $request)
    {   
        $apiKey = $request->api_key;
        
        $data = Member::where('api_key', $apiKey)->first();
        
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:members,email'],
            'phone' => 'required', 
        ]);

        $data = Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone, 
            'api_key' => 'ak_' . md5($request->phone . time()),
        ]);

        return response()->json($data, 200);
    }
}
