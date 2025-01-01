<?php
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('change-lang/{lang}', 'ChangeLangController@index')->name('chang.lang');
Route::get('/', function () {
    return view('auth.login');
});
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware(['auth:sanctum', 'verified','Blade'])->group(function () {

    Route::get('/app', function () {
        $role = Auth::user()->role;
        session()->put('role', strtolower($role->name));

        if ($role->id == 3) {
            return redirect()->back()->with(['errors_' => [__('msg.access_deny')]]);
        } else {
            return redirect()->route('dashboard');
        }
    });

    Route::get('/app/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('posts-index', [PostController::class, 'index'])->name('posts-index');
    Route::get('posts-datatable', [PostController::class, 'datatable'])->name('post.datatable');
    Route::post('save-post/{id?}', [PostController::class, 'save'])->name('post.save');
    Route::get('post-edit/{id}', [PostController::class, 'edit'])->name('post.edit');
    Route::get('block-post/{id}', [PostController::class, 'block'])->name('post.block');
    Route::get('unblock-post/{id}', [PostController::class, 'unblock'])->name('post.unblock');
});

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
