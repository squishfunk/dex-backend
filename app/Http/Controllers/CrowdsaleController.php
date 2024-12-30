<?php

namespace App\Http\Controllers;

use App\Models\Crowdsale;
use Illuminate\Http\Request;

class CrowdsaleController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'rate' => 'required|numeric',
                'contractAddress' => 'required|string|max:255',
                'tokenAddress' => 'required|string|max:255',
                'deployerAddress' => 'required|string|max:255',
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'details' => $e->getMessage()
            ], 422);
        }


        $crowdsale = Crowdsale::create($validatedData);

        return response()->json([
            'message' => 'Crowdsale created successfully!',
            'crowdsale' => $crowdsale,
        ], 201);
    }

    public function index()
    {
        $crowdsales = Crowdsale::with('token')->get();

        return response()->json($crowdsales);
    }
}
