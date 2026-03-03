<?php

use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\InvitationController;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShortUrlController::class, 'index'])->middleware('auth')->name('home');

Route::get('/login',[ShortUrlController::class, 'loginform'])->name('login');
Route::post('/login', [ShortUrlController::class, 'login']);
Route::get('/logout',[ShortUrlController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/invite',[InvitationController::class, 'inviteForm'])->name('invite.form');
    Route::post('/invite', [InvitationController::class, 'store'])->name('invite.store');

    // existing URL generation routes
    Route::get('/generateurl',[ShortUrlController::class, 'generateUrl'])->name('generateurl');
    Route::post('/generateurl', [ShortUrlController::class, 'storeUrl'])->name('generateurl.store');

    // shorthand endpoints used by tests (and future API)
    Route::get('/short-urls', [ShortUrlController::class, 'index'])->name('short-urls.index');
    Route::post('/short-urls', [ShortUrlController::class, 'storeUrl'])->name('short-urls.store');

    Route::get('/teammembers', [ShortUrlController::class, 'teamMembers'])->name('teammembers');
    Route::get('/generated-urls', [ShortUrlController::class, 'generatedUrls'])->name('generatedurls');
});
Route::get('/s/{code}', function ($code) {
    $shortUrl = ShortUrl::where('code', $code)->firstOrFail();
    $shortUrl->increment('hits');
    return redirect($shortUrl->url);
});
Route::post('/download', [ShortUrlController::class, 'download'])->name('download');