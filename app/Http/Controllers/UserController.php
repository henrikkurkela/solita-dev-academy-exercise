<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function createToken(Request $request)
    {
        $token = $request->user()->createToken('api_token');
        return redirect('dashboard')->with('success', "API token « $token->plainTextToken » created successfully.");
    }

    public function revokeAllTokens(Request $request)
    {
        $revoked = $request->user()->tokens()->delete();
        return redirect('dashboard')->with('success', "All $revoked API tokens revoked successfully.");
    }
}
