<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\UserDetails;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomRegistration extends Component
{
    public $firstname, $lastname, $username, $email, $password, $password_confirmation;

    public function render()
    {
        return view('livewire.auth.custom-registration');
    }

    public function registerCustom()
    {
        $data = $this->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ], [
            'username.unique' => 'This username is already taken.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'status' => "incompleted",
            'user_status' => 1, // Assuming 1 means active but pending approval
            'password' => Hash::make($data['password']),
        ]);

        UserDetails::create([
            'users_id' => $user->id,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
        ]);

        $this->dispatch('messageModal', 
            status: 'success', 
            position: 'top', 
            message: 'Registration successful! Please wait for administrator approval.'
        );
        
        return $this->redirect('/', navigate: true);
    }
}