<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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

    use RegistersUsers;

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectTo()
    {
        if (auth()->user()->role == 'masyarakat') {
            if (auth()->user()->status == 'pending') {
                return route('verification.notice');
            }
            return route('surat.my');
        }
        return route('dashboard');
    }

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
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'tanggal_lahir' => ['required', 'date'],
            'nik' => [
                'required',
                'string',
                'size:16',
                'exists:penduduk,nik',
                function ($attribute, $value, $fail) use ($data) {
                    $penduduk = \App\Models\Penduduk::where('nik', $value)->first();
                    
                    if (!$penduduk) {
                         return; // Handled by 'exists' rule
                    }

                    // Check if already registered
                    if ($penduduk->user_id) {
                        $fail('NIK ini sudah terdaftar dengan akun lain.');
                        return;
                    }

                    // Check DOB match
                    if ($penduduk->tanggal_lahir && $data['tanggal_lahir']) {
                         // Format both to Y-m-d to be sure
                         $dbDate = \Carbon\Carbon::parse($penduduk->tanggal_lahir)->format('Y-m-d');
                         $inputDate = \Carbon\Carbon::parse($data['tanggal_lahir'])->format('Y-m-d');

                         if ($dbDate !== $inputDate) {
                             $fail('Data NIK dan Tanggal Lahir tidak cocok dengan data kependudukan.');
                         }
                    }
                },
            ],
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
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'masyarakat', // Set role as masyarakat
            'status' => 'pending',
        ]);

        // Link user to penduduk
        $penduduk = \App\Models\Penduduk::where('nik', $data['nik'])->first();
        if ($penduduk) {
            $penduduk->user_id = $user->id;
            $penduduk->save();
        }

        return $user;
    }
}
