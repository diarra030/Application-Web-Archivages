<?php

use App\Http\Controllers\DocumentController;

use App\Http\Controllers\UserPermissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentEditor;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PdfView;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LicenceController;
use App\Http\Controllers\serviceFolder;
use Illuminate\Support\Facades\Request;
use App\Models\Folder;

Route::get('/newAccount', [RegisterController::class, 'index'])->middleware('checklicence')->name('register');
Route::post('/Account/store', [RegisterController::class, 'store'])->middleware('checklicence')->name('user.new');
Route::post('/licence/verify', [LicenceController::class, 'verify'])->name('licence.verify');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->middleware('checklicence')->name('dashboard');
})->group(function () {
    Route::get('/service', [ServiceController::class, 'index'])->middleware('checklicence')->name('service');
})->group(function () {
    Route::post('/service/store', [ServiceController::class, 'store'])->middleware('checklicence')->name('service.store');
})->group(function () {
    Route::get('/utilisateur', [UserController::class, 'index'])->middleware('checklicence', 'checkrole')->name('user');
})->group(function () {
    Route::get('/service/{id}', [ServiceController::class, 'show'])->middleware('checklicence')->name('service.show');
})->group(function () {
    Route::get('/utilisateur/{id}', [UserController::class, 'show'])->middleware('checklicence', 'checkrole')->name('user.show');
})->group(function () {
    Route::post('/utilisateur/store', [UserController::class, 'store'])->middleware('checklicence', 'checkrole')->name('user.store');
})->group(function () {
    Route::post('/utilisateur/store_role', [UserController::class, 'store_role'])->middleware('checklicence', 'checkrole')->name('user.store_role');
})->group(function () {
    Route::get('/utilisateur/{id}/edit', [UserController::class, 'edit'])->middleware('checklicence', 'checkrole')->name('users.edit');
})->group(function () {
    Route::put('/utilisateur/{id}', [UserController::class, 'update'])->middleware('checklicence', 'checkrole')->name('users.update');
})->group(function () {
    Route::delete('/utilisateur/{id}', [UserController::class, 'destroy'])->middleware('checklicence', 'checkrole')->name('users.destroy');
})->group(function () {
    Route::get('/document', [DocumentController::class, 'index'])->middleware('checklicence')->name('document');
})->group(function () {
    Route::get('/profile/{id}', [UserController::class, 'show_profile'])->middleware('checklicence')->name('profile');
})->group(function () {
    Route::put('/update_profile/{id}', [UserController::class, 'update_profile'])->middleware('checklicence')->name('user.update_profile');
})->group(function () {
    Route::post('/user/update_password', [UserController::class, 'update_password'])->middleware('checklicence')->name('user.update_password');
})->group(function () {
    Route::delete('/service/{id}', [ServiceController::class, 'destroy'])->middleware('checklicence')->name('service.destroy');
})->group(function () {
    Route::put('/service_update/{id}', [ServiceController::class, 'update'])->middleware('checklicence')->name('service.update');
})->group(function () {
    Route::get('/documents/{service}', [DocumentController::class, 'getDocuments'])->middleware('checklicence')->name(' ');
})->group(function () {
    Route::get('/api/users', [UserController::class, 'users.search'])->middleware('checklicence');
})->group(function () {
    Route::get('/tag/{id}', [TagController::class, 'index'])->middleware('checklicence')->name('tag');
})->group(function () {
    Route::post('/tag/store', [TagController::class, 'store'])->middleware('checklicence')->name('tag.store');
})->group(function () {
    Route::get('/message', [MessageController::class, 'index'])->middleware('checklicence')->name('message');
})->group(function () {
    Route::get('/message/{pivotId}', [MessageController::class, 'show'])->middleware('checklicence')->name('message.show');
})->group(function () {
    Route::get('/messageSended/{pivotId}', [MessageController::class, 'showSend'])->middleware('checklicence')->name('message.showSend');
})->group(function () {
    Route::post('/indentification/store/{id}', [ServiceController::class, 'identUser'])->middleware('checklicence')->name('service.ident');
})->group(function () {
    Route::get('/pdf/{id}', [PdfView::class, 'index'])->middleware('checklicence')->name('pdf.view');
})->group(function () {
    Route::delete('/document/{id}', [DocumentController::class, 'destroy'])->middleware('checklicence')->name('documents.destroy');
})->group(function () {
    Route::get('/historique', [HistoryController::class, 'index'])->middleware('checklicence')->name('history');
})->group(function () {
    Route::get('/export-historque-pdf', [HistoryController::class, 'exportPDF'])->middleware('checklicence')->name('history.export');
})->group(function(){
    Route::get('/api/users/search', [UserController::class, 'searchForSelect2'])->name('users.searchForSelect2');
})->group(function(){
    Route::get('/editer/{id}', [DocumentEditor::class, 'index'])->name('documents.edit');
})->group(function(){
    Route::get('/test', function () {
    return redirect()->route('folders.show', ['folder' => null]);
});
Route::get('/folders/{folderId?}', function (?int $folderId = null) {
    return view('folder-view', ['folderId' => $folderId]);
})->name('folders.show');
})->group(function () {
    Route::get('/documentsFolder/{service}', [serviceFolder::class, 'getFolderService']
    )->middleware('checklicence')->name('show_docs');});


    // =================================== route ajoute pas kevin N'doufou
