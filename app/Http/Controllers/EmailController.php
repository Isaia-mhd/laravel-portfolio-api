<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string|min:10', // Ensure the message is at least 10 characters
        ]);

        // If validation fails, Laravel will automatically return a 422 Unprocessable Entity response
        // You do not need to manually handle the validation error response.

        $apiKey = env("BREVO_API_KEY");

        // Making the request to Brevo API
        $response = Http::withHeaders([
            "api-key" => $apiKey,
            "Content-Type" => "application/json"
        ])->post('https://api.brevo.com/v3/smtp/email', [
            "sender" => [
                "name" => "IsaiaMohamed",
                "email" => "mohamedesaie21@gmail.com",
            ],
            "to" => [
                ["email" => "mohamedesaie21@gmail.com"]
            ],
            "subject" => $validated["subject"],
            "htmlContent" => view("emails.contact", [
                "email" => $validated["email"],
                "messageContent" => $validated["message"]
            ])->render(),
        ]);

        // Check if the response is successful
        if ($response->successful()) {
            return response()->json(['message' => 'Email sent successfully.']);
        } else {
            return response()->json([
                'error' => 'Failed to send email.',
                'details' => $response->json(),
            ], $response->status());
        }
    }
}
