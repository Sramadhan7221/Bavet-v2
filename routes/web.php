<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CMSController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('beranda');
Route::get('/artikel', [FrontController::class, 'blog'])->name('artikel.detail');
Route::get('/artikel-search', [FrontController::class, 'blogSearch'])->name('artikel.cari');
Route::get('/galeri/{page}', [FrontController::class, 'gallery'])->name('galeri.detail');



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

    Route::post('cms-page-status', [CMSController::class, 'changeStatus'])->name('admin.page-status');
    Route::post('cms-page-delete', [CMSController::class, 'deletePage'])->name('admin.page-delete');

    Route::get('cms-gallery', [CMSController::class, 'gallery'])->name('admin.gallery');
    Route::any('cms-gallery-detail', [CMSController::class, 'galleryDetail'])->name('admin.gallery.detail');

    Route::any('cms-tim', [CMSController::class, 'teams'])->name('admin.tim');
    Route::get('cms-tim-detail/{id}', [CMSController::class, 'teamById']);
    Route::post('cms-tim-delete', [CMSController::class, 'deleteTeam'])->name('admin.tim-delete');
    Route::post('cms-tim-struktur', [CMSController::class, 'changeStrukturalStatus'])->name('admin.tim-struktur');
    
    Route::get('cms-page', [CMSController::class, 'berita'])->name('admin.berita');
    Route::any('cms-page-detail', [CMSController::class, 'beritaDetail'])->name('admin.berita.detail');    
    Route::get('page-tags', [CMSController::class, 'pageTags'])->name('admin.berita.tags'); 
    
    Route::any('cms-layanan', [CMSController::class, 'services'])->name('admin.services');
    Route::get('cms-layanan-detail/{id}', [CMSController::class, 'serviceById']);
    Route::post('cms-layanan-delete', [CMSController::class, 'deleteService'])->name('admin.services-delete');  
    
    Route::any('cms-carousel', [CMSController::class, 'carouselBanner'])->name('admin.carousels');
    Route::post('cms-carousel-update', [CMSController::class, 'updateCarousel'])->name('admin.carousels-update');
    Route::post('cms-carousel-delete', [CMSController::class, 'deleteCarousel'])->name('admin.carousels-delete');

    Route::any('cms-testi', [CMSController::class, 'testimonial'])->name('admin.testi');
    Route::get('cms-testi-detail/{id}', [CMSController::class, 'testiById']);
    Route::post('cms-testi-delete', [CMSController::class, 'deleteTesti'])->name('admin.testi-delete');

    Route::any('cms-mitra', [CMSController::class, 'partner'])->name('admin.mitra');
    Route::get('cms-mitra-detail/{id}', [CMSController::class, 'partnerById']);
    Route::post('cms-mitra-delete', [CMSController::class, 'deletePartner'])->name('admin.mitra-delete');

    Route::any('cms-faq', [CMSController::class, 'faqData'])->name('admin.faq');
    Route::get('cms-faq-detail/{id}', [CMSController::class, 'faqById']);
    Route::post('cms-faq-delete', [CMSController::class, 'deleteFaq'])->name('admin.faq-delete');
});
