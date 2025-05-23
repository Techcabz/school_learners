<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Hash;

class Management extends Component
{
    public  $id, $username, $email, $firstname, $lastname, $password, $old_password;

    public function render()
    {
        $usersList = User::where('role_as', '0')->where('user_status', '0')->get();

        return view('livewire.admin.user.management', compact('usersList'));
    }

    public function userID($id)
    {
        $this->id = $id;
    }

    public function userDelete()
    {
        $user = User::findOrFail($this->id);
        $user->delete();

        $this->dispatch('saveModal', status: 'error', position: 'top', message: 'Delete user successfully');
    }

    public function editLoginDetails(int $id)
    {
        $users = User::where('id', $id)->first();

        if ($users) {
            $this->id = $users->id;
            $this->username = $users->username;
            $this->email = $users->email;
            $this->firstname = $users->userDetails->firstname;
            $this->lastname = $users->userDetails->lastname;
           
            $this->dispatch('editModal');
        }
    }

    public function saveLogindetails()
    {
        $user = User::findOrFail($this->id);
    
        $this->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
            'old_password' => ['nullable', 'string', function ($attribute, $value, $fail) use ($user) {
                if (!empty($this->password)) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('The old password is incorrect.');
                    }
                }
            }],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
        ]);
    
        // Update User table
        $user->update([
            'username' => $this->username,
            'email' => $this->email,
            'password' => empty($this->password) ? $user->password : Hash::make($this->password),
        ]);
    
        // Update or create related UserDetails
        UserDetails::updateOrCreate(
            ['users_id' => $user->id], // match condition
            [ // values to update or insert
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
            ]
        );
    
        $this->dispatch('saveModal', status: 'success', position: 'top', message: 'Information updated successfully');
    }
    

    public function closeModal()
    {
        $this->dispatch('closeModal');
    }
}
