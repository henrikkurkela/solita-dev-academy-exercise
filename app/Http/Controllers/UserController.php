<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function createToken(Request $request)
    {
        $token = $request->user()->createToken('api_token');
        return redirect('/tokens')->with('success', "API token « $token->plainTextToken » created successfully.");
    }

    public function revokeAllTokens(Request $request)
    {
        $revoked = $request->user()->tokens()->delete();
        return redirect('/tokens')->with('success', "All $revoked API tokens revoked successfully.");
    }

    public function revokeToken(Request $request, $id)
    {
        $request->user()->tokens()->where('id', $id)->delete();
        return redirect('/tokens')->with('success', "API token revoked successfully.");
    }

    public function getTokens(Request $request)
    {
        return view('token', [
            'tokens' => $request->user()->tokens()->get()
        ]);
    }
}
