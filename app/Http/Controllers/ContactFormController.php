<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactFormController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string',
            'newsletter' => 'nullable|boolean',
        ]);

        // Send email
        Mail::to('hola@innatotravel.com')->send(new ContactFormMail($data));

        return redirect()->back()->with('success', 'Mensaje enviado, gracias.');
    }
}
