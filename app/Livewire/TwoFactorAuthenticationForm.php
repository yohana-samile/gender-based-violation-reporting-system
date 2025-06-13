<?php

namespace App\Livewire;

use App\Traits\ConfirmsPasswords;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthenticationForm extends Component
{
    public $enabled;
    public $showingQrCode = false;
    public $showingConfirmation = false;
    public $showingRecoveryCodes = false;
    public $code = '';
    public $success = false;
    public $confirmingPassword = false;
    use ConfirmsPasswords;

    public function mount()
    {
        $this->enabled = !is_null(user()->two_factor_secret);
    }

    public function enableTwoFactorAuthentication()
    {
        $user = user();

        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();

        $user->forceFill([
            'two_factor_secret' => encrypt($secret),
            'two_factor_recovery_codes' => encrypt(json_encode(collect(range(1, 8))->map(fn () => Str::random(10))->all())),
        ])->save();

        $this->showingQrCode = true;
        $this->showingConfirmation = true;
        $this->enabled = true;
    }

    public function confirmTwoFactorAuthentication()
    {
        $user = user();
        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey(decrypt($user->two_factor_secret), $this->code);

        if ($valid) {
            $this->showingConfirmation = false;
            $this->success = true;
            // session()->flash('message', 'Two factor authentication confirmed.');
        } else {
            $this->addError('code', 'The provided OTP code is invalid.');
        }
    }

    public function regenerateRecoveryCodes()
    {
        user()->forceFill([
            'two_factor_recovery_codes' => encrypt(json_encode(collect(range(1, 8))->map(fn () => Str::random(10))->all())),
        ])->save();

        $this->showingRecoveryCodes = true;
    }

    public function showRecoveryCodes()
    {
        $this->showingRecoveryCodes = true;
    }

    public function disableTwoFactorAuthentication()
    {
        user()->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ])->save();

        $this->reset([
            'enabled',
            'showingQrCode',
            'showingRecoveryCodes',
            'showingConfirmation',
        ]);
    }

    public function getUserProperty()
    {
        return user();
    }

    public function startConfirmingPassword()
    {
        $this->resetErrorBag();
        $this->confirmingPassword = true;
    }

    /**
     * @throws ValidationException
     */
    public function confirmPassword()
    {
        $this->confirmPassword();
    }

    public function render()
    {
        return view('livewire.two-factor-authentication-form');
    }
}
