<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|in:programmer,girls,sports'
        ]);

        auth()->user()->update(['theme' => $validated['theme']]);

        return back()->with('success', 'Theme updated successfully');
    }
}