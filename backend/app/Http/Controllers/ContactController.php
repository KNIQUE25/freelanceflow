<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactMessageMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(StoreContactRequest $request)
    {
        $data = $request->validated();

        $recipient = config('mail.contact_recipient') ?: config('mail.from.address');

        try {
            Mail::to($recipient)->send(new ContactMessageMail(
                senderName: $data['name'],
                senderEmail: $data['email'],
                messageBody: $data['message'],
            ));
        } catch (\Throwable $e) {
            Log::error('Failed to send contact form email', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Sorry, we could not send your message right now. Please try again later.',
            ], 502);
        }

        return response()->json([
            'message' => 'Message sent successfully.',
        ], 200);
    }
}
