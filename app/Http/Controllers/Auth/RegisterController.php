<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Golongan;
use App\Models\Jabatan;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers{
        showRegistrationForm as preformShowRegistrationForm;
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'nip' => ['required','unique:users,nip'],
        ],[
            'name.required' => 'nama tidak boleh kosong',
            'name.string' => 'nama harus string',
            'name.max' => 'nama tidak boleh lebih dari 255 karakter',
            'email.required' => 'email tidak boleh kosong',
            'email.string' => 'email harus string',
            'email.email' => 'email harus menggunakan @',
            'email.max' => 'email tidak boleh lebih dari 255 karakter',
            'email.unique' => 'email sudah terdaftar',
            'nip.required' => 'nip tidak boleh kosong',
            'nip.unique' => 'nip sudah terdaftar'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nip' => $data['nip'],
            'golongan_id' => $data['golongan'],
            'jabatan_id' => $data['jabatan'],
            'level' => 'pegawai'
        ]);
    }

    public function showRegistrationForm(){
        $jabatans = Jabatan::all();
        $golongans = Golongan::all();
        return view('auth.register', compact('jabatans', 'golongans'));
    }
}
