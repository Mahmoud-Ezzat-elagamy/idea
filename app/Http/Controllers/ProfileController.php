<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Notifications\EmailChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', Password::defaults()],
        ]);

        //        we want to save the old email to send a notification to him in case of email changed
        $oldEmail = auth()->user()->email;

        auth()->user()->update(array_filter([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->has('password') ? $request->password : $user->password,
        ]));

        if ($oldEmail !== $request->email) {
            //            this will send the email to the old email address
            Notification::route('mail', $oldEmail)->notify(new EmailChanged($user, $oldEmail));
        }

        return to_route('profile.edit')->with('success', 'Your profile has been updated.');
    }
}
