<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shortUrls = ShortUrl::where('company_id', Auth::user()->company_id)->get();
        if (Auth::user()->role === User::ROLE_MEMBER) {
           $shortUrls = $shortUrls->where('user_id', Auth::user()->id);
        }
        else if (Auth::user()->role === User::ROLE_ADMIN) {
            $shortUrls = $shortUrls->whereIn('user_id', User::where('company_id', Auth::user()->company_id)->pluck('id'));
        }
        if (Auth::user()->role === User::ROLE_SUPER_ADMIN) {
            $companies = Company::all();
            foreach ($companies as $company) {
                $company->users = User::where('company_id', $company->id)->count();
                $company->total_urls = ShortUrl::whereIn('user_id', User::where('company_id', $company
->id)->pluck('id'))->count();
                $company->total_hits = ShortUrl::whereIn('user_id', User::where('company_id', $company->id)->pluck('id'))->sum('hits');
            }
            return view('superadminhome', compact('companies'));
        }          
        
       return view('memberhome', compact('shortUrls'));
    }

    public function generatedUrls()
    {
        $shortUrls = ShortUrl::with('company')->where('company_id', Auth::user()->company_id)->get();
        
        if (Auth::user()->role === User::ROLE_MEMBER) {
           $shortUrls = $shortUrls->where('user_id', Auth::user()->id);
        }
        else if (Auth::user()->role === User::ROLE_ADMIN) {
            $shortUrls = $shortUrls->whereIn('user_id', User::where('company_id', Auth::user()->company_id)->pluck('id'));
        }
        return view('memberhome', compact('shortUrls'));
    }
    public function loginform()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function generateUrl()
    {
        return view('generateurl');
    }

    public function storeUrl(Request $request)
    {
       $user = Auth::user();

        if (! in_array($user->role, [User::ROLE_ADMIN, User::ROLE_MEMBER], true)) {
            abort(403, 'You are not allowed to create short URLs.');
        }

        $data = $request->validate([
            'long_url' => ['required', 'url'],
        ]);

        $code = Str::random(8);

        ShortUrl::create([
            'company_id' => $user->company_id,
            'user_id' => $user->id,
            'code' => $code,
            'url' => $data['long_url'],
        ]);

        return back()->with('success', 'Short URL generated successfully!');
    }
    public function teamMembers()
    {
        
        if(Auth::user()->role === User::ROLE_MEMBER) {
            abort(403, 'You are not allowed to view team members.');
        }
        $members = User::where('company_id', Auth::user()->company_id)->get();
        if(Auth::user()->role === User::ROLE_ADMIN) {
            $members = $members->whereIn('role', [User::ROLE_MEMBER, User::ROLE_ADMIN]);
        }
        foreach ($members as $member) {
            $member->total_urls = ShortUrl::where('user_id', $member->id)->count();
            $member->total_hits = ShortUrl::where('user_id', $member->id)->sum('hits');
        }
        return view('teammembers', compact('members'));
    }


   public function download(Request $request)
    {
        $shortUrls = ShortUrl::where('company_id', Auth::user()->company_id)->get();

        if($request->has('filter') && $request->filter === 'thismonth') {
            $shortUrls = $shortUrls->where('created_at', '>=', now()->startOfMonth());
        }else if($request->has('filter') && $request->filter === 'lastmonth') {
            $shortUrls = $shortUrls->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
        }else if($request->has('filter') && $request->filter === 'lastweek') {
            $shortUrls = $shortUrls->where('created_at', '>=', now()->subDays(7));
        }else if($request->has('filter') && $request->filter === 'today') {
            $shortUrls = $shortUrls->where('created_at', '>=', now()->startOfDay());
        }
        if (Auth::user()->role === User::ROLE_MEMBER) {
           $shortUrls = $shortUrls->where('user_id', Auth::user()->id);
        }
        else if (Auth::user()->role === User::ROLE_ADMIN) {
            $shortUrls = $shortUrls->whereIn('user_id', User::where('company_id', Auth::user()->company_id)->pluck('id'));
        }
        $csvData = "Short URL,Long URL,Hits,Created At\n";
        foreach ($shortUrls as $shortUrl) {
            $csvData .= url("/s/{$shortUrl->code}") . "," . $shortUrl->url . "," . $shortUrl->hits . "," . $shortUrl->created_at . "\n";
        }
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="short_urls.csv"');
    }
}
