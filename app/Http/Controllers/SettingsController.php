<?php

namespace App\Http\Controllers;

use App\Services\SettingsService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function index()
    {
        $settings = $this->settingsService->getAllSettings();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');
        
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo');
        }

        if ($request->hasFile('favicon')) {
            $data['favicon'] = $request->file('favicon');
        }

        $this->settingsService->updateSettings($data);

        return redirect()->back()->with('success', 'Configuración actualizada correctamente.');
    }

    public function suggestColors(Request $request)
    {
        // Logic to handle logo upload for suggestion would go here
        // For now, just return the mocked suggestions
        return response()->json($this->settingsService->suggestColorsFromLogo(null));
    }

    public function suggestFonts(Request $request)
    {
        $type = $request->get('type', 'general');
        return response()->json($this->settingsService->suggestFonts($type));
    }
}
