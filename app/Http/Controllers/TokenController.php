<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'supply' => 'required|numeric|min:1',
            'logoURL' => 'nullable|url',
            'description' => 'nullable|string',
            'contractAddress' => 'required|string|max:255',
            'deployerAddress' => 'required|string|max:255',
        ]);

        $token = Token::create($validatedData);

        return response()->json([
            'message' => 'Token created successfully!',
            'token' => $token,
        ], 201);
    }

    public function index()
    {
        $tokens = Token::all();

        return response()->json($tokens);
    }
}
