<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppConfig;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class AppConfigController extends Controller
{
    public function index()
    {
        return view('appconfig.index');
    }
    public function store(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'logo_path' => 'nullable|image|max:2048',
            'mode_scan' => 'required|string'
        ]);

        // Get the first config, or create a new one
        $setting = AppConfig::first() ?? new AppConfig;

        if ($request->hasFile('logo_path')) {
            // Delete old logo if exists
            if ($setting->logo_path && Storage::disk('public')->exists($setting->logo_path)) {
                Storage::disk('public')->delete($setting->logo_path);
            }

            // Store new logo
            $path = $request->file('logo_path')->store('logos', 'public');
            $setting->logo_path = $path;
        }

        $setting->app_name = $request->app_name;
        $setting->mode_scan = $request->mode_scan;
        $setting->save();

        Cache::forget('setting');

        return response()->json(['message' => 'Pengaturan berhasil diperbarui!']);
    }
}
