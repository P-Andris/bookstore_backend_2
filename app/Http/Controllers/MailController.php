<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemoMail;

class MailController extends Controller
{
    public function index() {
        $mailData = [
            'title' => 'Mail from pillerandras0714@gmail.com',
            'body' => 'This is for testing email using smtp.'
        ];

        Mail::to('pillerandras0714@gmail.com')->send(new DemoMail($mailData));

        dd("Email sikeresen");
    }
}
