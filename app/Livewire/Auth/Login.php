<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[Layout('layout.app')]
#[Title('Login - Sistem Payroll')]
class Login extends Component
{
    public $email;
    public $password;

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return redirect()->intended('/');
        }

        $this->addError('email', 'Email atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
