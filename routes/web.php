<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactAddController;
use App\Http\Controllers\ContactSearchController;
use App\Http\Controllers\PendingContactsController;
use App\Http\Controllers\ProfileViewerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// error pages
Route::get('/error/{code}', [ErrorController::class, 'handleError']);

// auth routes
Route::get('/logout', [LogoutController::class, 'logout']);
Route::match(['get', 'post'], '/login', [LoginController::class, 'login']);
Route::match(['get', 'post'], '/register', [RegisterController::class, 'register']);

// main home controller
Route::get('/', [HomeController::class, 'homePage']);
Route::get('/home', [HomeController::class, 'homePage']);

// sub components
Route::get('/about', [AboutController::class, 'aboutPage']);

// search contact component
Route::get('/contact/search', [ContactSearchController::class, 'searchContact']);
Route::post('/contact/search', [ContactSearchController::class, 'searchContact']);

// profile viewer
Route::get('/profile', [ProfileViewerController::class, 'profileViewer']);
Route::post('/profile', [ProfileViewerController::class, 'profileViewer']);

// add contact to chats
Route::get('/contact/add', [ContactAddController::class, 'contactAdd']);

// list of pending contacts
Route::get('/pending/list', [PendingContactsController::class, 'pendingPage']);

// pending connection actions
Route::get('/pending/accept', [PendingContactsController::class, 'accept']);
Route::get('/pending/deny', [PendingContactsController::class, 'deny']);
