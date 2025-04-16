<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $images = collect(File::files(public_path('images/Profile_Img')))
                ->map(fn($file) => 'images/Profile_Img/' . $file->getFilename());

        return view('auth.register', compact('images'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'username' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'dob'=> ['required','date'],
            'imgPath'=> ['required', 'string']
        ]);

        // Debugging output
    dd($validatedData);

        $user = User::create($validatedData);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
