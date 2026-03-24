<?php

namespace App\Livewire\Manager;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Layout('layouts.auth')]
class Login extends Component
{

    public string $email;
    public string $password;

    public function login(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email', 'exists:managers,email', 'max:255'],
            'password' => ['required', 'string', 'max:255']
        ]);

        if (!Auth::guard('manager')->attempt([
            'email' => $this->email,
            'password' => $this->password
        ])) {
            if (RateLimiter::tooManyAttempts($this->email, 5)) {
                $this->addError('email', __('auth.throttle'));
                return;
            }

            RateLimiter::hit($this->email);
            $this->addError('email', __('auth.failed'));
            return;
        }

        RateLimiter::clear($this->email);

        $this->redirectIntended(route('manager.dashboard'));
    }


    #[Title('Manager login')]
    public function render(): View
    {
        return view('livewire.manager.login');
    }
}
