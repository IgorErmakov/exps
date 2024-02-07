<?php

use App\Http\Controllers\ProfileController;
use App\Models\Todo;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    $todoItems = Todo::all();
    return Inertia::render('Dashboard', [
        'todoItems' => $todoItems,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('/todo')->group(function () {

    Route::post('/', function (Request $request) {
        $item = $request->string('item')->trim();
        /** @var Todo $todo */
        $todo = Todo::create(['item' => $item]);

        return Redirect::route('dashboard');
    })->name('todo.create');

    Route::delete('/', function (Request $request) {
        $id = $request->integer('id');
        /** @var Todo $todo */
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return Redirect::route('dashboard');
    })->name('todo.delete');

    Route::put('/', function (Request $request) {
        $id = $request->integer('id');
        /** @var Todo $todo */
        $todo = Todo::findOrFail($id);
        $todo->completed = !$todo->completed;
        $todo->save();

        return Redirect::route('dashboard');
    })->name('todo.toggle_completed');
});

require __DIR__.'/auth.php';
