<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateSettingsController extends Controller
{
    public function __invoke(Request $request)
    {
        $attributes = $request->validate([
            'decimalPlaces' => ['sometimes', 'required', 'integer', 'min:0'],
            'percentageDecimalPlaces' => ['sometimes', 'required', 'integer', 'min:0'],
            'perShareDecimalPlaces' => ['sometimes', 'required', 'integer', 'min:0'],
            'publicView' => ['sometimes', 'required', 'boolean'],
        ]);

        $settings = $request->user()->settings ?? [];

        $settings = array_merge($settings, $attributes);

        $request->user()->update(['settings' => $settings]);

        return response()->json('Settings updated!', 200);
    }
}
