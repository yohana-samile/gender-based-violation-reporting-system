<?php
namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class LogoutOtherBrowserSessionsForm extends Component
{
    protected $sessions;
    public $password;
    public $confirmingLogout = false;
    public $success = false;

    protected $rules = [
        'password' => 'required|string|min:8',
    ];

    public function mount()
    {
        if (config('session.driver') !== 'database') {
            $this->sessions = collect();
            return;
        }

        $userId = user_id();
        $this->sessions = collect(
            DB::table('sessions')
                ->where('user_id', $userId)
                ->orderBy('last_activity', 'desc')
                ->get()
                ->map(function ($session) {
                    $agent = new Agent();
                    $agent->setUserAgent($session->user_agent);

                    return (object) [
                        'id' => $session->id,
                        'ip_address' => $session->ip_address,
                        'is_current_device' => $session->id === session()->getId(),
                        'agent' => $agent,
                        'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                    ];
                })
        );
    }

    public function confirmLogout()
    {
        $this->confirmingLogout = true;
    }

    public function logoutOtherBrowserSessions()
    {
        $this->validate();

        if (Hash::check($this->password, user()->password)) {
            DB::table('sessions')->where('user_id', user()->id)->where('id', '!=', session()->getId())->delete();

            $this->dispatch('loggedOut');
            $this->confirmingLogout = false;
            $this->password = '';
            $this->success = true;
        } else {
            $this->addError('password', __('The provided password is incorrect.'));
        }
    }

    public function getSessionsProperty()
    {
        return $this->sessions;
    }


    public function render()
    {
        return view('livewire.logout-other-browser-sessions-form', [
            'sessions' => $this->sessions,
        ]);
    }
}
