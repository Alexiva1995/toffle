<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        return redirect()->route('list.employees')->with('success', 'Empleado Registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = User::find($id);
        $password = Crypt::decrypt($employee->token_crypt);
        return view('admin.employees.edit')
        ->with('employee', $employee)
        ->with('password', $password);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        $employee->update();

        return redirect()->route('list.employees')->with('success', 'Empleado Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function list()
    {
        $employees = User::orderBy('id', 'DESC')->get();

        return view('admin.employees.list')->with('employees', $employees);
    }

    public function generatePassword(Request $request)
    {
        if ($request->ajax()) {
            $password = Str::random(8);
            return $password;
        }
    }
}
