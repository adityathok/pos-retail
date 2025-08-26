<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $settings = Setting::all()->keyBy('key');
        return response()->json($settings);
    }

    /**
     * Get general settings for the settings page
     */
    public function general(): JsonResponse
    {
        $generalSettings = [
            'company_name',
            'company_address', 
            'company_leader',
            'company_phone',
            'company_email'
        ];
        
        $settings = Setting::getMultiple($generalSettings);
        
        return response()->json($settings);
    }

    /**
     * Update general settings
     */
    public function updateGeneral(Request $request): JsonResponse
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:500',
            'company_leader' => 'required|string|max:255',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255'
        ]);

        $settings = [
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_leader' => $request->company_leader,
            'company_phone' => $request->company_phone,
            'company_email' => $request->company_email
        ];

        foreach ($settings as $key => $value) {
            if ($value !== null) {
                Setting::set($key, $value);
            }
        }

        return response()->json([
            'message' => 'Pengaturan berhasil disimpan',
            'settings' => $settings
        ]);
    }

    /**
     * Get single setting by key
     */
    public function getSetting(string $key): JsonResponse
    {
        $value = Setting::get($key);
        
        return response()->json([
            'key' => $key,
            'value' => $value
        ]);
    }

    /**
     * Set single setting
     */
    public function setSetting(Request $request, string $key): JsonResponse
    {
        $request->validate([
            'value' => 'required',
            'type' => 'sometimes|string|in:string,integer,boolean,json',
            'description' => 'sometimes|string|max:500'
        ]);

        $type = $request->get('type', 'string');
        $description = $request->get('description');
        
        Setting::set($key, $request->value, $type, $description);
        
        return response()->json([
            'message' => 'Pengaturan berhasil disimpan',
            'key' => $key,
            'value' => $request->value
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
