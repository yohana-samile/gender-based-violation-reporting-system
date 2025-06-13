<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UpdateProfileInformation extends Component
{
    use WithFileUploads;

    public $state = [];
    public $photo;
    public $success = false;
    public $verificationLinkSent = false;

    public function mount()
    {
        $this->state = user()->only('name', 'email');
    }

    public function updateProfileInformation()
    {
        $user = user();
        $this->validate([
            'state.name' => 'required|string|max:255',
            'state.email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|max:1024', // 1MB Max for photo
        ]);

        if ($this->state['email'] !== $user->email) {
            $user->email_verified_at = null;
            $user->save();
        }

        if ($this->photo) {
            $path = $this->photo->store('profile-photos', 'public');
            $user->update([
                'name' => $this->state['name'],
                'email' => $this->state['email'],
                'profile_photo_path' => $path,
            ]);
        } else {
            $user->update([
                'name' => $this->state['name'],
                'email' => $this->state['email'],
            ]);
        }
        $this->success = true;
    }

    public function deleteProfilePhoto()
    {
        $user = user();
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->update(['profile_photo_path' => null]);
        }
        $this->success = true;
    }

    public function sendEmailVerification()
    {
        $user = user();
        $user->sendEmailVerificationNotification();
        $this->verificationLinkSent = true;
    }

    public function render()
    {
        return view('livewire.update-profile-information');
    }
}
