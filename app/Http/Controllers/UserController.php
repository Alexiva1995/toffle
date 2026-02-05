<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): void
    {
        //
    }

    public function create(): View
    {
        return view('admin.employees.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $fields = [
            'name' => ['required'],
            'last_name' => ['required'],
            'dni' => ['required', 'unique:users'],
            'phone' => ['required'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required'],
            'salary' => ['required'],
            'date_birth' => ['required'],
            'status' => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            'last_name.required' => 'El apellido es requerido.',
            'dni.required' => 'El DNI es requerido.',
            'phone.required' => 'El número de teléfono es requerido.',
            'email.required' => 'El correo es requerido.',
            'email.unique' => 'El correo debe ser único. Este correo ya está registrado.',
            'dni.unique' => 'El dni debe ser único. Este dni ya está registrado.',
            'password.required' => 'La contraseña es requerida.',
            'salary.required' => 'El sueldo base es requerido.',
            'date_birth.required' => 'La fecha de nacimiento es requerido.',
            'status.required' => 'El estatus es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $employee = User::create($request->all());
        $employee->password = Hash::make($request->password);
        $employee->token_crypt = Crypt::encrypt($request->password);
        $employee->save();

        return redirect()->route('employees.list')->with('success', 'Empleado Registrado');
    }

    public function show(int $id): void
    {
        //
    }

    public function showActiveUsers(): View
    {
        $sessions = Session::with('user')->where('user_id', '!=', null)->get();
        return view('admin.sessions.index', compact('sessions'));
    }

    public function edit(int $id): View
    {
        $employee = User::find($id);
        $password = Crypt::decrypt($employee->token_crypt);
        return view('admin.employees.edit')
        ->with('employee', $employee)
        ->with('password', $password);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $employee = User::find($id);

        $fields = [
            'name' => ['required'],
            'last_name' => ['required'],
            'dni' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required'],
            'salary' => ['required'],
            'date_birth' => ['required'],
            'status' => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            'last_name.required' => 'El apellido es requerido.',
            'dni.required' => 'El DNI es requerido.',
            'phone.required' => 'El número de teléfono es requerido.',
            'email.required' => 'El correo es requerido.',
            'password.required' => 'La contraseña es requerida.',
            'salary.required' => 'El sueldo base es requerido.',
            'date_birth.required' => 'La fecha de nacimiento es requerido.',
            'status.required' => 'El estatus es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $employee->update($request->all());
        $employee->password = Hash::make($request->password);
        $employee->token_crypt = Crypt::encrypt($request->password);
        $employee->save();

        return redirect()->route('employees.list')->with('success', 'Empleado Actualizado');
    }

    public function destroy(int $id): RedirectResponse
    {
        $employee = User::find($id);
        $employee->delete();
        return redirect()->route('employees.list')->with('success', 'Empleado Eliminado');
    }

    public function list(): View
    {
        $employees = User::orderBy('id', 'DESC')->get();
        return view('admin.employees.list')->with('employees', $employees);
    }

    public function generatePassword(Request $request): ?string
    {
        if ($request->ajax()) {
            return Str::random(8);
        }
        return null;
    }
}
