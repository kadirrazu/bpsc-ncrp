<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigurationController extends Controller
{
    public function setMasterConfigs()
    {
        $configs = DB::table('configs')->orderBy('id', 'ASC')->get();

        return view('dashboard.configs', ['configs' => $configs]);
    }

    public function updateMasterConfigs(Request $request)
    {

        $data = $request->validate([
            'configs' => 'required|array',
            'configs.*.key' => 'required|string',
            'configs.*.value' => 'required|string',
            'configs.*.remarks' => 'nullable|string'
        ]);

        DB::table('configs')->truncate();

        foreach ($data['configs'] as $row) {
            DB::table('configs')->insert($row);
        }

        return redirect()->back()->with('success', 'Configuration settings saved successfully.');
    }

} //End of the Class
