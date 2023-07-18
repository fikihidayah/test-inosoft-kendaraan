<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function me(Request $request)
    {
        return response()->json([
            'status' => 200,
            'data' => $request->user(),
        ]);
    }
}
