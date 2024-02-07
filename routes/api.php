<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Todo;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('todo')->group(function () {

    Route::get('/', function () {
        $todoItems = Todo::all();
        return $todoItems;
    });

    Route::post('/', function (Request $request) {
        $item = $request->string('item')->trim();
        /** @var Todo $todo */
        $todo = Todo::create(['item' => $item]);

        return ['todo' => $todo];
    })->name('todo.create');

    Route::delete('/{id}', function (Request $request, int $id) {
        /** @var Todo $todo */
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return ['result' => true];
    })->name('todo.delete');

    Route::put('/{id}', function (Request $request, int $id) {
        /** @var Todo $todo */
        $todo = Todo::findOrFail($id);
        $todo->completed = !$todo->completed;
        $todo->save();

        return ['item' => $todo];
    })->name('todo.toggle_completed');
});
