<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit(Request $request)
    {
        $adminId = $request->user()->getAdminId();
        $settings = Setting::forAdmin($adminId);

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $allowedCurrencies = implode(',', array_keys(Setting::CURRENCIES));

        $request->validate([
            'loan_duration_days' => 'required|integer|min:1|max:365',
            'max_active_loans' => 'required|integer|min:1|max:50',
            'fine_per_day' => 'required|numeric|min:0|max:999999',
            'currency' => 'required|string|in:' . $allowedCurrencies,
        ]);

        $adminId = $request->user()->getAdminId();
        $settings = Setting::forAdmin($adminId);

        $settings->update([
            'loan_duration_days' => $request->loan_duration_days,
            'max_active_loans' => $request->max_active_loans,
            'fine_per_day' => $request->fine_per_day,
            'currency' => $request->currency,
        ]);

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Paramètres mis à jour avec succès.');
    }
}
