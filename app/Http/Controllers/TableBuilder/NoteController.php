<?php

namespace App\Http\Controllers\TableBuilder;

use App\Http\Controllers\Controller;
use App\Models\CompanyTableComparison;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function __invoke(CompanyTableComparison $table, Request $request)
    {
        $request->validate([
            'ticker' => ['required', 'string'],
            'note' => ['nullable', 'string'],
        ]);

        $notes = $request->notes;
        $notes[$request->ticker] = $request->note;

        $table->update(['notes' => $notes]);
    }
}
