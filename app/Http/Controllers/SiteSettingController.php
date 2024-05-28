<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $data = Setting::paginate(10);
        return view('superadmin.settings.setting-list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = new Setting();
        return view('superadmin.settings.setting-create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $input = $request->except(['_token']);


        $result = Setting::create($input);

        notyf()->addSuccess('Setting Created Succesfully');

        return redirect()->route('settings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
