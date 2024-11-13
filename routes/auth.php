<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
  Route::get('register', [RegisteredUserController::class, 'create'])
    ->name('register');

  Route::post('register', [RegisteredUserController::class, 'store']);

  Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

  Route::post('login', [AuthenticatedSessionController::class, 'store']);

  Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');

  Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

  Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');

  Route::post('reset-password', [NewPasswordController::class, 'store'])
    ->name('password.store');
});

Route::middleware('auth')->group(function () {
  Route::get('verify-email', EmailVerificationPromptController::class)
    ->name('verification.notice');

  Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

  Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('verification.send');

  Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->name('password.confirm');

  Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

  Route::put('password', [PasswordController::class, 'update'])->name('password.update');

  Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

  Route::prefix('contacts')->group(function () {
    Route::get(
      '/',
      \App\Http\Controllers\Contacts\Index::class
    )->name('contacts.index');

    Route::get(
      '/c/new',
      \App\Http\Controllers\Contacts\Form::class
    )->name('contacts.create');

    Route::post(
      '/store',
      \App\Http\Controllers\Contacts\Store::class
    )->name('contacts.store');

    Route::get(
      '/s/{contact:cid}',
      \App\Http\Controllers\Contacts\Show::class
    )->name('contacts.show');

    Route::get(
      '/e/{contact:cid}',
      \App\Http\Controllers\Contacts\Form::class
    )->name('contacts.edit');

    Route::patch(
      '/u/{contact:cid}',
      \App\Http\Controllers\Contacts\Update::class
    )->name('contacts.update');

    Route::delete(
      '/d/{ids}',
      \App\Http\Controllers\Contacts\Destroy::class
    )->name('contacts.destroy');

    Route::put(
      '/r/{contact:cid}',
      \App\Http\Controllers\Contacts\Restore::class
    )->name('contacts.restore');
  });

  Route::prefix('projects')->group(function () {
    Route::get(
      '/',
      \App\Http\Controllers\Projects\Index::class
    )->name('projects.index');

    Route::post(
      '/store',
      \App\Http\Controllers\Projects\Store::class
    )->name('projects.store');

    Route::get(
      '/s/{project:pid}',
      \App\Http\Controllers\Projects\Show::class
    )->name('projects.show');

    Route::get(
      '/c/p/{contact:cid?}',
      \App\Http\Controllers\Projects\Form::class
    )->name('projects.create');

    Route::get(
      '/e/{project:pid}',
      \App\Http\Controllers\Projects\Form::class
    )->name('projects.edit');

    Route::patch(
      '/u/{project:pid}',
      \App\Http\Controllers\Projects\Update::class
    )->name('projects.update');

    Route::delete(
      '/d/{ids}',
      \App\Http\Controllers\Projects\Destroy::class
    )->name('projects.destroy');

    Route::delete(
      '/f/{project:pid}',
      \App\Http\Controllers\Projects\Upload::class
    )->name('projects.upload');
  });


  Route::prefix('boards')->group(function () {

    Route::post(
      '/s/{project:pid}',
      \App\Http\Controllers\Boards\Store::class
    )->name('boards.store');

    Route::patch(
      '/u/{project}/{board}',
      \App\Http\Controllers\Boards\Update::class
    )->name('boards.update');

    Route::delete(
      'd/{project}/{board}',
      \App\Http\Controllers\Boards\Destroy::class
    )->name('boards.destroy');

  });

  Route::prefix('tasks')->group(function () {

    Route::get(
      '/',
      \App\Http\Controllers\Tasks\Index::class
    )->name('tasks.index');

    Route::post(
      '/',
      \App\Http\Controllers\Tasks\Store::class
    )->name('tasks.store');

    Route::get(
      '/s/{task:tid}/{notification?}',
      \App\Http\Controllers\Tasks\Show::class
    )->name('tasks.show');

    Route::patch(
      '/u/{task}',
      \App\Http\Controllers\Tasks\Update::class
    )->name('tasks.update');

    Route::delete(
      '/d/{task}',
      \App\Http\Controllers\Tasks\Destroy::class
    )->name('tasks.destroy');

    Route::put(
      '/m/{task}',
      \App\Http\Controllers\Tasks\Move::class
    )->name('tasks.move');

  });

  Route::prefix('comments')->group(function () {

    Route::post(
      '/{task}',
      \App\Http\Controllers\Comments\Store::class
    )->name('comments.store');

    Route::patch(
      '/u/{comment}',
      \App\Http\Controllers\Comments\Update::class
    )->name('comments.update');

    Route::delete(
      '/d/{comment}',
      \App\Http\Controllers\Comments\Destroy::class
    )->name('comments.destroy');

  });

//personal route
  Route::prefix('reports')->group(function () {

    Route::get(
      '/download',
      \App\Http\Controllers\Reports\Download::class
    )->name('reports.download');

    Route::post(
      '/w',
      \App\Http\Controllers\Reports\Report::class
    )->name('reports.compile');

    Route::delete(
      '/d/{report}',
      \App\Http\Controllers\Reports\Destroy::class
    )->name('reports.destroy');

    Route::get(
      '/{user?}',
      \App\Http\Controllers\Reports\Index::class
    )->name('reports.index');

  });

  Route::get(
    '/download/{file:fid}',
    \App\Http\Controllers\Files\Download::class
  )->name('file.downloads');

  Route::get(
    '/profile',
    [\App\Http\Controllers\ProfileController::class, 'edit']
  )->name('profile.edit');

  Route::patch(
    '/profile',
    [\App\Http\Controllers\ProfileController::class, 'update']
  )->name('profile.update');

  Route::delete(
    '/profile',
    [\App\Http\Controllers\ProfileController::class, 'destroy']
  )->name('profile.destroy');

  Route::get(
    '/',
    \App\Http\Controllers\Dashboard\Index::class
  )->name('dashboard');

});
