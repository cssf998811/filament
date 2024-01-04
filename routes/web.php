<?php

use App\Models\User;
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

// FIXME:先暫時導到link方便開發，後續應該要根據權限導到對應的登入頁面，可參考User Model的canAccessPanel()
Route::get('/', function () {
    return view('link');
    // return redirect('tenantPortal');
    // return redirect('tenantAdmin');
    // return redirect('admin');
});