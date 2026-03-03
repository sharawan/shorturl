<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
        

    public function inviteForm()
    {
        return view('invite');
    }
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $user = Auth::user();
        $companyId = $user?->company_id;
        if($user->role !== 'super_admin' && $user->role !== 'admin') {
            return back()->withErrors(['email' => 'You do not have permission to send invitations']);
        }
        $request->validate([
            'client_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,member',
        ]);
        Invitation::create([
            'company_id' => $companyId,
            'inviter_id' => $user->id,
            'client_name' => $request->client_name,
            'email' => $request->email,
            'role' => $request->role,
            'token' => Str::random(32),
        ]);
       
        // Here you would typically send an email to the invited client with the invitation token

        Mail::raw('You have been invited to join our platform. Use the following token to accept the invitation: ' . $request->token, function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Invitation to Join');
        });

        return back()->with('success', 'Invitation sent successfully!');
    }

    
}
