<?php

namespace App\Repositories;

use App\Models\User;
use App\Mail\LoginAlertMail;
use App\Models\City;
use App\Models\Organisations;
use App\Models\OrganisationTypes;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{

    public function create()
    {
        return view('auth.login');
    }
    public function login(array $data): User
    {
        $user = User::where('email', $data['email'])->first();

        if ($user && Auth::attempt(['email' => $data['email'], 'password' => $data['password']]) && $user->role == 'admin') {

            // Send email
            $ip = request()->ip();
            $agent = request()->userAgent();
            $browser = get_browser_name($agent);
            $platform = get_os_name($agent);

            if (Mail::to($user->email)->send(new LoginAlertMail($user, $ip, $browser, $platform))) {

                return $user;
            } else {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'email' => ['email not sent'],
                ]);
            }
        }

        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    public function profile()
    {
        return Auth::user();
        
    }
    public function profile_update($data)
    {
        $user = Auth::user();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->number = $data['number'];
        if (isset($data['image']) && $data['image']->isValid()) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $imageName = time() . '.' . $data['image']->getClientOriginalExtension();
            $path = $data['image']->storeAs('uploads/profile_images', $imageName, 'public');
            $user->image = $path;
        }
        $user->save();
        return $user;
    }

    public function getusers()
    {
        $users =  User::where('role', '!=', 'admin')->get();
        return $users;
    }

    public function get_create_data(){
        $data['organizations'] = Organisations::all();
        $data['organisation_types'] = OrganisationTypes::all();
        $data['provinces'] = Province::all();
        $data['cities'] = City::all();

        return $data;
    }

    public function store_user(array $data){
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->number = $data['number'];
        $user->password = Hash::make($data['password']);
        $user->role = $data['role'];
        $user->cnic = $data['cnic'];
        $user->dob = $data['dob'];
        $user->class = $data['class'];
        $user->gender = $data['gender'];
        $user->hobbies = $data['hobbies'];
        $user->sports_played = $data['sports_played'];
        $user->guardian_name = $data['guardian_name'];
        $user->guardian_email = $data['guardian_email'];
        $user->guardian_number = $data['guardian_phone'];
        $user->guardian_dob = $data['guardian_dob'];
        $user->city = $data['city'];
        $user->organisation_type = $data['organisation_type'];
        $user->organisation_id = $data['organisation'];
        $user->state_province= $data['province'];
        $user->country= 166; // Pakistan
        if (isset($data['image']) && $data['image']->isValid()) {
            $imageName = time() . '.' . $data['image']->getClientOriginalExtension();
            $path = $data['image']->storeAs('uploads/profile_images', $imageName, 'public');
            $user->image = $path;
        }
        $user->save();
    }

    public function get_user($id){
        $user = User::find($id);
        return $user;
    }

    public function update_user(array $data, $id){
        $user = User::find($id);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->number = $data['number'];
        $user->role = $data['role'];
        if (isset($data['password']) && !empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->cnic = $data['cnic'];
        $user->dob = $data['dob'];
        $user->class = $data['class'];
        $user->gender = $data['gender'];
        $user->hobbies = $data['hobbies'];
        $user->sports_played = $data['sports_played'];
        $user->guardian_name = $data['guardian_name'];
        $user->guardian_email = $data['guardian_email'];    
        $user->guardian_number = $data['guardian_phone'];
        $user->guardian_dob = $data['guardian_dob'];
        $user->city = $data['city'];
        $user->organisation_type = $data['organisation_type'];
        $user->organisation_id = $data['organisation'];
        $user->state_province= $data['province'];
        if (isset($data['image']) && $data['image']->isValid()) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $imageName = time() . '.' . $data['image']->getClientOriginalExtension();
            $path = $data['image']->storeAs('uploads/profile_images', $imageName, 'public');
            $user->image = $path;
        }
        $user->save();
        return $user;
    }

    public function delete_user($id)
{
    $user = User::find($id);
    if (!$user) {
        return false;
    }

    if ($user->image) {
        $imagePath = str_replace(url('/storage'), 'storage', $user->image);
        $fullPath = public_path($imagePath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    $user->delete();
    return true;
}

}
