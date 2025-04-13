<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Administrator extends Component
{
    public  $id, $username, $email, $password, $old_password;

    public function render()
    {
        $currentUserId = Auth::id();
        // ->where('id', '!=', $currentUserId) 

        $usersList = User::where('role_as', '1')
            ->where('user_status', '0')
            ->get();

        return view('livewire.admin.user.administrator', compact('usersList'));
    }

    public function userID($id)
    {
        $this->id = $id;
    }

    public function editLoginDetails(int $id)
    {
        $users = User::where('id', $id)->first();

        if ($users) {
            $this->id = $users->id;
            $this->username = $users->username;
            $this->email = $users->email;

            $this->dispatch('editModal');
        }
    }

    public function userDelete()
    {
        $user = User::findOrFail($this->id);
        if ($user->role_as == 1) {
            $adminCount = User::where('role_as', 1)->where('user_status', 0)->count();

            if ($adminCount <= 1) {
                $this->dispatch('destroyModal', status: 'error', position: 'top', message: 'Cannot delete the only remaining admin.');
                return;
            }
        }

        $user->delete();

        $this->dispatch('saveModal', status: 'warning', position: 'top', message: 'User deleted successfully.');
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
            }]
        ]);

        // Update User table
        $user->update([
            'username' => $this->username,
            'email' => $this->email,
            'password' => empty($this->password) ? $user->password : Hash::make($this->password),
        ]);



        $this->dispatch('saveModal', status: 'success', position: 'top', message: 'Information updated successfully');
    }


    public function closeModal()
    {
        $this->dispatch('closeModal');
    }
}
