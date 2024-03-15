<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateSettingsController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'decimalPlaces' => ['sometimes', 'required', 'integer', 'min:0'],
        ]);

        $settings = $request->user()->settings ?? [];

        if ($request->has('decimalPlaces')) {
            $settings['decimalPlaces'] = $request->decimalPlaces;
        }

        $request->user()->update(['settings' => $settings]);

        return response()->json('Settings updated!', 200);
    }
}
