<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('pages.contact');
    }

    public function store(Request $request): RedirectResponse
    {
        if (filled($request->input('website'))) {
            return redirect()->route('contact')->with('status', 'Thanks — your message was sent.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'message' => ['required', 'string', 'max:10000'],
        ]);

        $to = config('site.contact_email');
        $body = "Name: {$validated['name']}\nEmail: {$validated['email']}\n\n".$validated['message'];

        DB::transaction(function () use ($validated, $to, $body) {
            ContactMessage::query()->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'message' => $validated['message'],
            ]);

            Mail::raw($body, function ($message) use ($validated, $to) {
                $message->to($to)
                    ->replyTo($validated['email'], $validated['name'])
                    ->subject('tjshafer.com contact: '.$validated['name']);
            });
        });

        return redirect()->route('contact')->with('status', 'Thanks — your message was sent.');
    }
}
