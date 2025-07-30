<?php

use App\Http\Controllers\DocumentEditor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// Route pour recevoir les mises à jour de ONLYOFFICE
Route::post('wopi/files/{id}', [DocumentEditor::class, 'callback']);