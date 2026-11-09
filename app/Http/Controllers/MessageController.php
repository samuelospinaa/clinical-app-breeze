<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Mail\MessageMail;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return Inertia::render('Contact/index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request): RedirectResponse
    {
       $data = $request->validated();
       $message = Message::create($data);

       Mail::to('ecovedigital@gmail.com')->queue(new MessageMail($message));

       return back();
    }
}
