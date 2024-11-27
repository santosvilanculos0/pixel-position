<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class User extends Component
{
    use WithFileUploads;

    public $name = null;

    public $email = null;

    public $password = null;

    public $password_confirmation = null;

    public $employer = null;

    public ?TemporaryUploadedFile $logo = null;

    public $logo_path = null;

    public function update()
    {
        $this->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(Auth::id())],
            'password' => ['nullable', 'confirmed', Password::min(6)],
            'employer' => ['required'],
            'logo' => ['nullable', File::types(['png', 'jpg', 'webp'])],
        ]);

        $user = Auth::user();
        if (isset($this->password)) {
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
        } else {
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);
        }

        if (isset($this->logo)) {
            $this->logo_path = $this->logo->store('logos', ['disk' => 'public']);
        }

        $user->employer()->update([
            'name' => $this->employer,
            'logo' => $this->logo_path,
        ]);

        $this->reset(['password', 'password_confirmation', 'logo']);
        $this->resetValidation();

    }

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;

        $this->email = $user->email;
        $this->employer = $user->employer->name;
        $this->logo_path = $user->employer->logo;
    }

    public function render()
    {
        return view('livewire.user');
    }
}
