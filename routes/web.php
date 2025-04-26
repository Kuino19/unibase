<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AIStudyAssistantController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FriendController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    Route::get('/ai-study-assistant', function () {
        return view('ai-study-assistant');
    })->name('ai-study-assistant');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// AI Study Assistant Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/ai/summarize', [AIStudyAssistantController::class, 'summarize'])->name('ai.summarize');
    Route::post('/ai/generate-questions', [AIStudyAssistantController::class, 'generateQuestions'])->name('ai.generate-questions');
    Route::post('/ai/explain-concept', [AIStudyAssistantController::class, 'explainConcept'])->name('ai.explain-concept');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{user}', [ChatController::class, 'store'])->name('chat.store');
    Route::post('/chat/{user}/read', [ChatController::class, 'markAsRead'])->name('chat.read');
});

// Friendships
Route::middleware(['auth'])->group(function () {
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    Route::post('/friends/{user}/add', [FriendshipController::class, 'sendRequest'])->name('friends.add');
    Route::post('/friends/{friendship}/accept', [FriendshipController::class, 'acceptRequest'])->name('friends.accept');
    Route::post('/friends/{user}/remove', [FriendshipController::class, 'removeFriend'])->name('friends.remove');
});

// Notifications
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

require __DIR__.'/auth.php';
