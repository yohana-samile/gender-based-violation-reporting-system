<?php
namespace App\Livewire;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordForm extends Component
{

    public $current_password;
    public $password;
    public $password_confirmation;
    public $success = false;

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'same:password_confirmation'],
            'password_confirmation' => ['required'],
        ]);

        user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->success = true;
    }

    public function render()
    {
        return view('livewire.update-password-form');
    }
}
