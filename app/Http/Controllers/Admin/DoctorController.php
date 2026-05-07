<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::with('user')->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
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
    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$doctor->user_id,
            'id_number' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
            'specialty' => 'required|string|max:255',
            'license_number' => 'nullable|string|max:255',
        ]);

        $doctor->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'id_number' => $request->id_number,
            'phone' => $request->phone,
        ]);

        $doctor->update([
            'specialty' => $request->specialty,
            'license_number' => $request->license_number,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
