<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CMSController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index']);


Route::any('login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('cms', function () {
        return view('dashboard',['title' => "Admin"]);
    })->name('dashboard');
    Route::get('cms-manage/{slug}', [CMSController::class, 'manage'])->where('slug', '[A-Za-z0-9\-]+')->name('cms.manage');
    Route::any('cms-menus', [CMSController::class, 'menuList'])->name('menus.tree');
    Route::get('menu-parent', [CMSController::class, 'searchParent'])->name('menus.parent');
    Route::get('menu-detail/{id}', [CMSController::class, 'menuDetail'])->name('menus.item');
    Route::post('menu-delete', [CMSController::class, 'menuDelete'])->name('menus.item-delete');
    Route::post('menu-order', [CMSController::class, 'menuReorder'])->name('menus.item-order');

    Route::any('cms-home', [CMSController::class, 'home'])->name('admin.home');
    Route::any('cms-about', [CMSController::class, 'about'])->name('admin.about');
    Route::post('cms-upload-asset', [CMSController::class, 'uploadAsset'])->name('asset.upload');
    Route::post('cms-delete-asset', [CMSController::class, 'deleteAsset'])->name('asset.delete');
});
