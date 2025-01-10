<?php
// app/Http/Controllers/EmailController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validation des données d'entrée
        $validated = $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string|min:10',
        ]);

        // Envoi de l'email en utilisant la classe ContactMail
        Mail::to($validated['email'])->send(new ContactMail(
            $validated['email'],
            $validated['subject'],
            $validated['message']
        ));

        // Retourner une réponse JSON
        return response()->json(['message' => 'Email envoyé avec succès.']);
    }
}
