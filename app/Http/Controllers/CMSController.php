<?php

namespace App\Http\Controllers;

use App\Models\AboutContent;
use App\Models\CarouselBanner;
use App\Models\HomeContent;
use App\Models\Karyawan;
use App\Models\Menus;
use App\Models\PageAssets;
use App\Models\Pages;
use App\Models\Service;
use App\Models\Tags;
use App\Services\FileService;
use App\Services\HomeContentService;
use App\Validators\AboutValidator;
use App\Validators\BeritaValidator;
use App\Validators\CarouselBannerValidator;
use App\Validators\GalleryValidator;
use App\Validators\HomeValidator;
use App\Validators\KaryawanValidator;
use App\Validators\MenuValidator;
use App\Validators\ServiceValidator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class CMSController extends Controller
{

    public function __construct(private FileService $fileService) {}

    // public function menuList(Request $request)
    // {
    //     if ($request->isMethod('POST')) {
    //         try {
    //             $validated = MenuValidator::validate($request, $request->id);
    //             $sameSlug = Menus::where('slug', $validated['slug'])->count();
    //             $message = "Menu berhasil ditambahkan, silahkan refresh halaman untuk menampilkan menu pada sidebar";
    //             $parent = null;

    //             DB::transaction(function () use ($sameSlug, $validated, $request, &$message, &$parent) {
    //                 if ($sameSlug > 0) {
    //                     $validated['slug'] = sprintf('%s-%s', $validated['slug'], $sameSlug);
    //                 }

    //                 if ($request->filled('parent_id') && !is_numeric($request->parent_id)) {
    //                     $parentMenu = Menus::create([
    //                         'title' => $request->parent_id,
    //                         'slug' => Str::slug($request->parent_id),
    //                         'type' => 'parent',
    //                         'is_active' => 'true',
    //                         'created_by' => auth('web')->user()->id
    //                     ]);
    //                     $validated['parent_id'] = $parentMenu->id;
    //                     $parent = ['id' => $parentMenu->id, 'title' => $parentMenu->title];
    //                 }

    //                 if ($request->filled('id')) {
    //                     $menu = Menus::where('id', $request->id)
    //                         ->lockForUpdate()
    //                         ->first();

    //                     if ($menu->type !== 'parent')
    //                         $menu->type = $validated['type'];

    //                     $menu->title = $validated['title'];
    //                     $menu->external_url = $validated['external_url'];
    //                     $menu->parent_id = $validated['parent_id'];
    //                     $menu->is_active = $validated['is_active'];

    //                     $menu->save();
    //                     $message = "Berhasil update menu " . $validated['title'];
    //                 } else {
    //                     $validated['created_by'] = auth('web')->user()->id;
    //                     Menus::create($validated);
    //                 }
    //             });

    //             return response()->json(['msg_type' => "success", 'message' => $message, 'with_parent' => $parent]);
    //         } catch (ValidationException $e) {
    //             $errors = $e->validator->errors();
    //             return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
    //         } catch (\Throwable $th) {
    //             Log::error('[MenuController] System Error: ' . $th->getMessage() . ' at line ' . $th->getLine());
    //             return response()->json(['msg_type' => "error", 'message' => 'Terjadi kesalahan. Silahkan coba beberapa saat.'], 500);
    //         }
    //     }

    //     if ($request->ajax()) {
    //         $parentId = $request->get('parentId', null);

    //         // Ambil root jika tidak ada parentId, atau anak dari parent tertentu
    //         $menus = Menus::where('parent_id', $parentId)->orderBy('order_seq')->get();

    //         $response = $menus->map(function ($menu) {
    //             return [
    //                 'title'  => $menu->title,
    //                 'key'    => (string) $menu->id,  // key harus string
    //                 'folder' => $menu->type == 'parent', // folder jika punya anak
    //                 'lazy'   => $menu->type == 'parent', // lazy load anak
    //                 'slug'   => $menu->slug,
    //                 'menu_type'   => $menu->type,
    //                 'menu_id' => $menu->id
    //             ];
    //         });

    //         return response()->json($response);
    //     }

    //     return view('admin.menus', [
    //         'title' => 'Menu Management',
    //     ]);
    // }

    // public function searchParent(Request $request)
    // {
    //     $q = strtolower($request->q);
    //     $data = Menus::where('type', 'parent')->where(DB::raw("LOWER(title)"), 'LIKE', "%$q%")->get(['id', 'title']);

    //     return response()->json(['success' => 1, 'msg' => "Berhasil", 'data' => $data]);
    // }

    // public function menuReorder(Request $request)
    // {
    //     $validator = Validator::make($request->all(), ['menu_list' => 'required|array']);
    //     if ($validator->fails()) {
    //         return response()->json(['msg' => "Invalid Request", "msg_type" => "error"], 400);
    //     }

    //     try {
    //         DB::transaction(function () use ($validator) {
    //             $validated = $validator->validate();
    //             $menus = Menus::whereIn('id', $validated['menu_list'])
    //                 ->lockForUpdate()
    //                 ->get()
    //                 ->keyBy('id');

    //             foreach ($validated['menu_list'] as $index => $itemId) {
    //                 if (!isset($menus[$itemId])) {
    //                     throw new \Exception("ID $itemId not found or not accessible.");
    //                 }

    //                 $menus[$itemId]->update(['order_seq' => $index + 1]);
    //             }
    //         });

    //         return response()->json(['msg_type' => "success", 'message' => "Urutan menu berhasil diupdate"]);
    //     } catch (\Throwable $th) {
    //         Log::error('[MenuController] System Error: ' . $th->getMessage() . ' at line ' . $th->getLine());
    //         return response()->json(['msg_type' => "error", 'message' => 'Terjadi kesalahan. Silahkan coba beberapa saat.'], 500);
    //     }
    // }

    // public function menuDetail($id)
    // {
    //     $menu = Menus::find($id);
    //     return response()->json(['data' => $menu]);
    // }

    // public function menuDelete(Request $request)
    // {
    //     $validator = Validator::make($request->all(), ['code' => 'required']);
    //     if ($validator->fails()) {
    //         return response()->json(['msg' => "Invalid Request", "msg_type" => "error"], 400);
    //     }

    //     try {
    //         $id = $request->code;
    //         $menu = Menus::where('id', $id)
    //             ->with('children')
    //             ->first();

    //         if (!$menu) {
    //             return response()->json(['msg' => "Gagal dihapus, menu tidak ditemukan. kemungkinan menu telah dihapus", "msg_type" => "warning"], 400);
    //         }

    //         if ($menu->type == 'parent' && count($menu->children) > 0) {
    //             return response()->json(['msg' => "Gagal dihapus, menu memiliki sub-menu. silahkan hapus sub-menu terkait", "msg_type" => "warning"], 400);
    //         }

    //         if (Menus::where('id', $id)->delete())
    //             return response()->json(['msg' => "Menu berhasil dihapus", "msg_type" => "success"]);
    //         else
    //             return response()->json(['msg' => "Menu gagal dihapus", "msg_type" => "warning"]);
    //     } catch (\Throwable $th) {
    //         Log::error('Kesalahan Sistem: ' . $th->getMessage());
    //         return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
    //     }
    // }


    public function home(Request $request)
    {
        try {
            // === GET REQUEST: Show Form ===
            if ($request->isMethod('GET')) {
                return view('admin.home-content', [
                    'title' => 'Home Content',
                    'content' => HomeContent::getInstance()
                ]);
            }

            // === POST REQUEST: Update Content ===
            $request->validate([
                'type' => 'required|in:hero,vm,pengujian'
            ], [
                'type.required' => 'Parameter type tidak boleh kosong',
                'type.in' => 'Tipe request tidak valid'
            ]);

            $homeContent = null;

            // Wrap dalam transaction untuk atomicity
            DB::transaction(function () use ($request, &$homeContent) {
                $homeContentService = new HomeContentService($this->fileService);
                switch ($request->type) {
                    case 'hero':
                        $validated = HomeValidator::validate($request);
                        $homeContent = $homeContentService->updateHero(
                            $validated,
                            $request->file('image_hero')
                        );
                        break;

                    case 'vm':
                        $validated = HomeValidator::validateVM($request);
                        $homeContent = $homeContentService->updateVisionMission(
                            $validated,
                            $request->file('vm_banner')
                        );
                        break;

                    case 'pengujian':
                        $validated = HomeValidator::validatePengujian($request);
                        $homeContent = $homeContentService->updatePengujian($validated);
                        break;
                }
            });

            return response()->json([
                'msg_type' => 'success',
                'message' => 'Konten berhasil diupdate',
                'data' => [
                    'updated_at' => $homeContent?->updated_at->toDateTimeString()
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'msg_type' => 'warning',
                'message' => $e->validator->errors()->first(),
                'errors' => $e->validator->errors()
            ], 400);

        } catch (\Throwable $th) {
            Log::error('[HomeController] System Error', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString()
            ]);

            return response()->json([
                'msg_type' => 'error',
                'message' => 'Terjadi kesalahan sistem, silakan coba lagi'
            ], 500);
        }
    }

    public function about(Request $request)
    {
        try {
            if ($request->isMethod('POST')) {
                $validated = AboutValidator::validate($request, $request->id);
                if ($request->hasFile('image_hero')) {
                    $image = $request->file('image_hero');
                    $filename = sprintf('about-%s', Str::uuid());
                    $path = $this->fileService->saveFile($image, $filename, 'about');

                    $validated['image_hero'] = url($path);
                }

                if ($request->hasFile('image_visimisi')) {
                    $image = $request->file('image_visimisi');
                    $filename = sprintf('about-%s', Str::uuid());
                    $path = $this->fileService->saveFile($image, $filename, 'about');

                    $validated['image_visimisi'] = url($path);
                }

                if ($request->filled('id'))
                    AboutContent::where('id', $request->id)->update($validated);
                else
                    AboutContent::create($validated);

                $data = [
                    'image_hero' => isset($validated['image_hero']) ? $validated['image_hero'] : null,
                    'image_visimisi' => isset($validated['image_visimisi']) ? $validated['image_visimisi'] : null
                ];
                return response()->json(['msg_type' => "success", 'message' => "success", 'data' => $data]);
            }

            $content = Pages::where('slug', 'about')->first();
            return view('admin.about-content', [
                'title' => 'Tentang Content',
                'content' => AboutContent::first(),
                'page_id' => $content->id
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
        } catch (\Throwable $th) {
            Log::error('Kesalahan Sistem: ' . $th->getMessage());
            return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
        }
    }

    public function uploadAsset(Request $request)
    {
        try {

            $request->validate([
                'upload' => 'required|mimes:jpg,jpeg,png|max:2048'
            ]);

            $image = $request->file('upload');
            $asset = $this->saveImageAsset($image, 'page-assets', $request->page_id);

            return response()->json(['message' => "Image Uploaded", 'msg_type' => 'success', 'url' => $asset->url]);
        } catch (ValidationException $e) {
            $message = collect($e->validator->errors()->all())->map(fn($v) => "<p>$v</p>")->implode('');
            return response()->json(['message' => $message, 'msg_type' => 'warning'], 400);
        } catch (\Throwable $th) {
            Log::error('[CMS] System Error: ' . $th->getMessage() . ' at line ' . $th->getLine());
            return response()->json(['message' => 'Terjadi Kesalahan, silahkan coba beberapa saat lagi', 'msg_type' => 'error'], 500);
        }
    }

    public function deleteAsset(Request $request)
    {
        try {
            $request->validate([
                'old_url' => 'required|url'
            ]);

            if ($this->fileService->deleteFile($request->old_url)) {
                PageAssets::where('url', $request->old_url)->delete();
                return response()->json(['message' => "Berhasil menghapus gambar", 'msg_type' => 'success']);
            } else {
                return response()->json(['message' => "Gagal menghapus gambar", 'msg_type' => 'warning']);
            }
        } catch (ValidationException $e) {
            $message = collect($e->validator->errors()->all())->map(fn($v) => "<p>$v</p>")->implode('');
            return response()->json(['message' => $message, 'msg_type' => 'warning'], 400);
        } catch (\Throwable $th) {
            Log::error('[CMS] System Error: ' . $th->getMessage() . ' at line ' . $th->getLine());
            return response()->json(['message' => 'Terjadi Kesalahan, silahkan coba beberapa saat lagi', 'msg_type' => 'error'], 500);
        }
    }

    public function gallery(Request $request)
    {
        try {

            if ($request->ajax()) {
                $model = Pages::query()
                    ->select(['slug', 'banner', 'title', 'is_active', 'created_at'])->where('type', 'gallery');

                return DataTables::of($model)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($page) {
                        Carbon::setLocale('id');
                        $date = Carbon::parse($page->created_at);
                        $formattedDate = $date->translatedFormat('d F, Y');
                        return $formattedDate;
                    })
                    ->make(true);
            }

            return view('admin.gallery.list', [
                'title' => 'Galeri'
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
        } catch (\Throwable $th) {
            Log::error('Kesalahan Sistem: ' . $th->getMessage());
            return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
        }
    }

    public function galleryDetail(Request $request)
    {

        $slug = $request->slug;

        if ($request->isMethod('POST')) {
            try {
                $validated = GalleryValidator::validate($request, $request->id);
                if ($request->hasFile('banner')) {
                    $image = $request->file('banner');
                    $filename = sprintf('gb-%s', Str::uuid());
                    $path = $this->fileService->saveFile($image, $filename, 'gallery-banners');

                    $validated['banner'] = url($path);
                }

                if ($request->id) {
                    if (isset($validated['assets']) && is_array($validated['assets'])) {
                        foreach ($validated['assets'] as $assetId) {
                            PageAssets::where('url', $assetId)->update(['page_id' => $request->id]);
                        }
                    }

                    if (isset($validated['delete_assets']) && is_array($validated['delete_assets'])) {
                        foreach ($validated['delete_assets'] as $assetId) {
                            if ($this->fileService->deleteFile($assetId))
                                PageAssets::where('url', $assetId)->delete();
                        }
                    }

                    unset($validated['assets'], $validated['delete_assets']);
                    Pages::where('id', $request->id)->update($validated);
                    $item = Pages::where('id', $request->id)->first();
                    $banner = $item?->banner;
                    $message = "Galeri berhasil diperbarui";
                } else {
                    $validated['slug'] = Str::slug($validated['title']);
                    if (Pages::where('slug', $validated['slug'])->exists()) {
                        $validated['slug'] = sprintf('%s-%s', Str::slug($validated['title']), Pages::where('type', 'gallery')->count() + 1);
                    }

                    $validated['type'] = 'gallery';
                    $validated['created_by'] = auth('web')->user()->id;
                    $validated['is_active'] = 'true';

                    $newItem = Pages::create($validated);
                    if (isset($validated['assets']) && is_array($validated['assets'])) {
                        foreach ($validated['assets'] as $assetId) {
                            PageAssets::where('url', $assetId)->update(['page_id' => $newItem->id]);
                        }
                    }

                    $banner = $newItem->banner;
                    $message = "Galeri berhasil ditambahkan";
                }

                return response()->json(['msg_type' => "success", 'message' => $message, 'banner' => $banner ?? '#']);
            } catch (ValidationException $e) {
                $message = collect($e->validator->errors()->all())->map(fn($v) => "<p>$v</p>")->implode('');
                return response()->json(['message' => $message, 'msg_type' => 'warning'], 400);
            } catch (\Throwable $th) {
                Log::error('Kesalahan Sistem: ' . $th->getMessage());
                return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
            }
        } elseif (!$request->isMethod('GET')) {
            abort(405);
        }

        $item = Pages::where('slug', $slug)->first();
        return view('admin.gallery.detail', [
            'title' => $slug ? 'Edit Galeri' : 'Add Galeri',
            'gallery' => $item,
            'assets' => $item ? PageAssets::where('page_id', $item->id)->get('url')->map(fn($value) => $value->url)->toArray() : []
        ]);
    }

    public function changeStatus(Request $request)
    {
        try {
            $request->validate([
                'slug' => ['required', 'string'],
                'is_active' => ['required', Rule::in(['true', 'false'])]
            ]);

            $page = Pages::where('slug', $request->slug)->first();
            if (!$page) {
                return response()->json(['msg_type' => "warning", 'message' => "Data tidak ditemukan"], 404);
            }

            $page->is_active = $request->is_active;
            $page->save();

            return response()->json(['msg_type' => "success", 'message' => "Status berhasil diupdate"]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
        } catch (\Throwable $th) {
            Log::error('Kesalahan Sistem: ' . $th->getMessage());
            return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
        }
    }

    public function deletePage(Request $request)
    {
        try {
            $request->validate([
                'slug' => ['required', 'string']
            ]);

            $page = Pages::where('slug', $request->slug)->first();
            if (!$page) {
                return response()->json(['msg_type' => "warning", 'message' => "Data tidak ditemukan"], 404);
            }

            DB::transaction(function () use ($page) {
                $urls = PageAssets::where('page_id', $page->id)->pluck('url')->toArray();
                foreach ($urls as $url) {
                    if(!$this->fileService->deleteFile($url))
                        Log::alert('[CMS] Gagal menghapus asset dengan url: ' . $url);
                }
                PageAssets::where('page_id', $page->id)->delete();
                $page->delete();
            });

            return response()->json(['msg_type' => "success", 'message' => "Halaman berhasil dihapus"]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
        } catch (\Throwable $th) {
            Log::error('Kesalahan Sistem: ' . $th->getMessage());
            return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
        }
    }

    public function teams(Request $request)
    {
        if($request->isMethod('POST')) {
            try {
                $validated = KaryawanValidator::validate($request, $request->id);

                if($request->has('img_profile')) {
                    $image = $request->file('img_profile');
                    $filename = sprintf('team-%s', Str::uuid());
                    $path = $this->fileService->saveFile($image, $filename, 'teams');
                    $validated['img_profile'] = url($path);
                }

                if(isset($validated['id']))
                {
                    if(!$validated['urutan']) {
                        $validated['urutan'] = Karyawan::count();
                    }
                    Karyawan::where('id', $validated['id'])->update($validated);
                    return response()->json(['msg_type' => "success", 'message' => "Update berhasil"]);
                }
                else {
                    Karyawan::create($validated);
                    return response()->json(['msg_type' => "success", 'message' => "Simpan berhasil"]);
                }
            } catch (ValidationException $e) {
                $errors = $e->validator->errors();
                return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
            } catch (\Throwable $th) {
                Log::error('[CMS] System Error: ' . $th->getMessage() . ' at line ' . $th->getLine());
                return response()->json(['message' => 'Terjadi Kesalahan, silahkan coba beberapa saat lagi', 'msg_type' => 'error'], 500);
            }  
        }

        if($request->ajax())
        {
            $model = Karyawan::query()
                ->select(['id','nama','nip','img_profile','jabatan','bio','struktural','urutan']);

            return DataTables::of($model)
            ->addIndexColumn()
            ->rawColumns(['bio'])
            ->make(true);
        }

        return view('admin.team', [
            'title' => 'Management Profil Pegawai'
        ]);
    }

    public function teamById($id)
    {
        $team = Karyawan::where('id', $id)->select(['nama','nip','img_profile','jabatan','bio','instagram','facebook','tiktok', 'urutan'])->first(); 
        return response()->json(['msg' => "Berhasil",'msg_type' => 'success','data' => $team]);
    }

    public function changeStrukturalStatus(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required', 'numeric'],
                'struktural' => ['required', Rule::in(['true', 'false', true, false])]
            ]);

            $team = Karyawan::where('id', $request->id)->first();
            if (!$team) {
                return response()->json(['msg_type' => "warning", 'message' => "Data tidak ditemukan"], 404);
            }

            $team->struktural = boolval($request->struktural);
            $team->save();

            return response()->json(['msg_type' => "success", 'message' => "Data berhasil diupdate"]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
        } catch (\Throwable $th) {
            Log::error('Kesalahan Sistem: ' . $th->getMessage());
            return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
        }
    }

    public function deleteTeam(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required', 'string']
            ]);

            $team = Karyawan::where('id', $request->id)->first();
            if (!$team) {
                return response()->json(['msg_type' => "warning", 'message' => "Data tidak ditemukan"], 404);
            }

            $team->delete();
            return response()->json(['msg_type' => "success", 'message' => "Data berhasil dihapus"]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
        } catch (\Throwable $th) {
            Log::error('Kesalahan Sistem: ' . $th->getMessage());
            return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
        }
    }

    public function berita(Request $request)
    {
        try {

            if ($request->ajax()) {
                $model = Pages::query()
                    ->select(['slug', 'banner', 'title', 'is_active', 'created_at'])->where('type', 'blog')
                    ->where('slug', '!=', 'about');

                return DataTables::of($model)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($page) {
                        Carbon::setLocale('id');
                        $date = Carbon::parse($page->created_at);
                        $formattedDate = $date->translatedFormat('d F, Y');
                        return $formattedDate;
                    })
                    ->make(true);
            }

            return view('admin.berita.list', [
                'title' => 'Berita'
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
        } catch (\Throwable $th) {
            Log::error('Kesalahan Sistem: ' . $th->getMessage());
            return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
        }
    }

    public function beritaDetail(Request $request)
    {

        $slug = $request->slug;

        if ($request->isMethod('POST')) {
            try {
                $validated = BeritaValidator::validate($request, $request->id);
                if ($request->hasFile('banner')) {
                    $image = $request->file('banner');
                    $filename = sprintf('pb-%s', Str::uuid());
                    $path = $this->fileService->saveFile($image, $filename, 'page-banners');

                    $validated['banner'] = url($path);
                }

                if ($request->id) {
                    if (isset($validated['assets']) && is_array($validated['assets'])) {
                        foreach ($validated['assets'] as $assetId) {
                            PageAssets::where('url', $assetId)->update(['page_id' => $request->id]);
                        }
                    }

                    if (isset($validated['delete_assets']) && is_array($validated['delete_assets'])) {
                        foreach ($validated['delete_assets'] as $assetId) {
                            if ($this->fileService->deleteFile($assetId))
                                PageAssets::where('url', $assetId)->delete();
                        }
                    }

                    if (isset($validated['tags']) && is_array($validated['tags'])) {
                        $tagIds = [];
                        foreach($validated['tags'] as $tagName) {
                            $tag = Tags::where(DB::raw('LOWER(tag_name)'), $tagName)->first();
                            if(!$tag)
                                $tag = Tags::create(['tag_name' => $tagName]);
                            $tagIds[] = $tag->id;                            
                        }
                        
                        $page = Pages::find($request->id);
                        $page->tags()->sync($tagIds);
                    }

                    unset($validated['assets'], $validated['delete_assets'], $validated['tags']);
                    Pages::where('id', $request->id)->update($validated);
                    $item = Pages::where('id', $request->id)->first();
                    $banner = $item?->banner;
                    $message = "Berita berhasil diperbarui";
                } else {
                    $validated['slug'] = Str::slug($validated['title']);
                    if (Pages::where('slug', $validated['slug'])->exists()) {
                        $validated['slug'] = sprintf('%s-%s', Str::slug($validated['title']), Pages::where('type', 'gallery')->count() + 1);
                    }

                    $validated['type'] = 'blog';
                    $validated['created_by'] = auth('web')->user()->id;
                    $validated['is_active'] = 'true';

                    $newItem = Pages::create($validated);
                    if (isset($validated['assets']) && is_array($validated['assets'])) {
                        foreach ($validated['assets'] as $assetId) {
                            PageAssets::where('url', $assetId)->update(['page_id' => $newItem->id]);
                        }
                    }

                    if (isset($validated['tags']) && is_array($validated['tags'])) {
                        $tagIds = [];
                        foreach($validated['tags'] as $tagName) {
                            $tag = Tags::where(DB::raw('LOWER(tag_name)'), $tagName)->first();
                            if(!$tag)
                                $tag = Tags::create(['tag_name' => $tagName]);
                            $tagIds[] = $tag->id;                            
                        }
                        
                        $newItem->tags()->sync($tagIds);
                    }

                    $banner = $newItem->banner;
                    $message = "Berita berhasil ditambahkan";
                }

                return response()->json(['msg_type' => "success", 'message' => $message, 'banner' => $banner ?? '#']);
            } catch (ValidationException $e) {
                $message = collect($e->validator->errors()->all())->map(fn($v) => "<p>$v</p>")->implode('');
                return response()->json(['message' => $message, 'msg_type' => 'warning'], 400);
            } catch (\Throwable $th) {
                Log::error('Kesalahan Sistem: ' . $th->getMessage());
                return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
            }
        } elseif (!$request->isMethod('GET')) {
            abort(405);
        }

        $item = Pages::where('slug', $slug)->with('tags')->first();
        return view('admin.berita.detail', [
            'title' => $slug ? 'Edit Berita' : 'Add Berita',
            'berita' => $item
        ]);
    }

    public function pageTags(Request $request)
    {
        $q = strtolower($request->q);
        $data = Tags::where(DB::raw("LOWER(tag_name)"),'LIKE',"%$q%")->get(['id','tag_name']);

        return response()->json(['success' => 1, 'msg' => "Berhasil",'data' => $data]);
    }

    public function services(Request $request)
    {
        if($request->isMethod('POST')) {
            try {
                $validated = ServiceValidator::validate($request);

                if($request->has('icon')) {
                    $image = $request->file('icon');
                    $filename = sprintf('layanan-%s', Str::uuid());
                    $path = $this->fileService->saveFile($image, $filename, 'layanan');
                    $validated['icon'] = '<img src="'.url($path).'" width="76" height="76">';
                }

                if($request->has('banner')) {
                    $image = $request->file('banner');
                    $filename = sprintf('banner-%s', Str::uuid());
                    $path = $this->fileService->saveFile($image, $filename, 'layanan');
                    $validated['banner'] = url($path);
                }

                if(isset($validated['id']))
                {
                    Service::where('id', $validated['id'])->update($validated);
                    return response()->json(['msg_type' => "success", 'message' => "Update berhasil"]);
                }
                else {
                    Service::create($validated);
                    return response()->json(['msg_type' => "success", 'message' => "Simpan berhasil"]);
                }
            } catch (ValidationException $e) {
                $errors = $e->validator->errors();
                return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
            } catch (\Throwable $th) {
                Log::error('[CMS] System Error: ' . $th->getMessage() . ' at line ' . $th->getLine());
                return response()->json(['message' => 'Terjadi Kesalahan, silahkan coba beberapa saat lagi', 'msg_type' => 'error'], 500);
            }  
        }

        if($request->ajax())
        {
            $model = Service::query()
                ->select(['id','title','desc','icon']);

            return DataTables::of($model)
            ->addIndexColumn()
            ->rawColumns(['icon'])
            ->make(true);
        }

        return view('admin.services', [
            'title' => 'Layanan Utama'
        ]);
    }

    public function serviceById($id)
    {
        $team = Service::where('id', $id)->select(['icon','banner','title','desc','content'])->first(); 
        return response()->json(['msg' => "Berhasil",'msg_type' => 'success','data' => $team]);
    }

    public function deleteService(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required']
            ]);

            $layanan = Service::where('id', $request->id)->first();
            if (!$layanan) {
                return response()->json(['msg_type' => "warning", 'message' => "Data tidak ditemukan"], 404);
            }

            if (preg_match('/src="([^"]+)"/', $layanan->icon, $match)) {
                $src = $match[1];
                if(!$this->fileService->deleteFile($src))
                    Log::alert('[CMS] Gagal menghapus asset icon dengan url: ' . $src);
            }

            if(!empty($layanan->banner)) {
                if(!$this->fileService->deleteFile($layanan->banner))
                    Log::alert('[CMS] Gagal menghapus asset banner dengan url: ' . $layanan->banner);
            }

            $layanan->delete();
            return response()->json(['msg_type' => "success", 'message' => "Data berhasil dihapus"]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
        } catch (\Throwable $th) {
            Log::error('Kesalahan Sistem: ' . $th->getMessage());
            return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
        }
    }

    public function carouselBanner(Request $request)
    {
        if($request->isMethod('POST')) {
            try {

                $request->validate([
                    'banner' => 'required|mimes:jpg,jpeg,png|max:5096'
                ]);

                $image = $request->file('banner');
                $carouselItem = DB::transaction(function () use ($image) {
                    try {

                        $maxUrutan = CarouselBanner::lockForUpdate()->max('urutan') ?? 0;

                        $imgPath = $this->fileService->saveFile($image, Str::uuid(),'carousel-assets');
                        $urlPath = url($imgPath);

                        return CarouselBanner::create([
                            'img_path' => $urlPath,
                            'urutan' => $maxUrutan + 1
                        ]);
                    } catch (\Throwable $th) {
                        Log::error("[CMSController] Failed to save carouselItem: {$th->getMessage()}");
                        throw $th;
                    }
                });
               

                return response()->json(['message' => "Image Uploaded", 'msg_type' => 'success', 'url' => $carouselItem->img_path, 'id' => $carouselItem->id]);

            } catch (ValidationException $e) {
                $errors = $e->validator->errors();
                return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
            } catch (\Throwable $th) {
                Log::error('[CMS] System Error: ' . $th->getMessage() . ' at line ' . $th->getLine());
                return response()->json(['message' => 'Terjadi Kesalahan, silahkan coba beberapa saat lagi', 'msg_type' => 'error'], 500);
            }  
        }

        if($request->ajax())
        {
            $model = CarouselBanner::query()
                ->select(['id','img_path','urutan','status'])
                ->orderBy('urutan', 'asc');

            return DataTables::of($model)
            ->make(true);
        }

        return view('admin.carousels', [
            'title' => 'Carousel Konten Management'
        ]);
    }

    public function updateCarousel(Request $request)
    {
        try {
            $request->validate([
                'banners' => 'nullable|array|min:1',
                'banners.*.id' => 'required|integer|exists:carousel_banners,id',
                'banners.*.urutan' => 'required|integer|min:1',
                'id' => 'nullable|integer',
                'status' => 'nullable|in:active,inactive'
            ]);

            if($request->filled('banners')) {
                $banners = $request->banners;
                
                // Validasi urutan unik
                $urutanValues = array_column($banners, 'urutan');
                if(count($urutanValues) !== count(array_unique($urutanValues))) {
                    return response()->json([
                        'message' => "Urutan tidak boleh ada yang sama", 
                        'msg_type' => 'error'
                    ], 422);
                }
                
                DB::transaction(function () use ($banners) {
                    $ids = array_column($banners, 'id');
                    
                    // 🔑 PENTING: Sort untuk consistent lock ordering
                    sort($ids, SORT_NUMERIC);
                    
                    // Lock dengan urutan konsisten
                    $bannersById = CarouselBanner::whereIn('id', $ids)
                        ->orderBy('id', 'asc') // Enforce consistent order
                        ->lockForUpdate()
                        ->get()
                        ->keyBy('id');
                    
                    // Validasi lengkap
                    if($bannersById->count() !== count($ids)) {
                        $found = $bannersById->pluck('id')->toArray();
                        $missing = array_diff($ids, $found);
                        throw new \Exception("Banner tidak ditemukan: " . implode(', ', $missing));
                    }
                    
                    // Update urutan
                    foreach($banners as $banner) {
                        $bannersById[$banner['id']]->urutan = $banner['urutan'];
                        $bannersById[$banner['id']]->save();
                    }
                });
                
                return response()->json([
                    'message' => "Urutan banner berhasil diupdate",
                    'msg_type' => 'success',
                    'updated_count' => count($banners)
                ]);
            }
            
            elseif ($request->filled(['id','status'])) {
                $bannerItem = CarouselBanner::findOrFail($request->id);
                $bannerItem->status = $request->status;
                $bannerItem->save();
                
                return response()->json([
                    'message' => "Status banner berhasil diupdate",
                    'msg_type' => 'success'
                ]);
            }
            
            return response()->json([
                'message' => "Parameter request tidak lengkap", 
                'msg_type' => 'error'
            ], 400);
            
        } catch (\Throwable $th) {
            Log::error('[CMS] updateCarousel Error: ' . $th->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan, silahkan coba lagi',
                'msg_type' => 'error'
            ], 500);
        }
    }

    public function deleteCarousel(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required']
            ]);

            $item = CarouselBanner::where('id', $request->id)->first();
            if (!$item) {
                return response()->json(['msg_type' => "warning", 'message' => "Data tidak ditemukan"], 404);
            }

            if(!$this->fileService->deleteFile($item->img_path))
                Log::alert('[CMS] Gagal menghapus asset carousel banner dengan url: ' . $item->img_path);

            $item->delete();
            return response()->json(['msg_type' => "success", 'message' => "Data berhasil dihapus"]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
        } catch (\Throwable $th) {
            Log::error('Kesalahan Sistem: ' . $th->getMessage());
            return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
        }
    }

    private function saveImageAsset(UploadedFile $file, string $path, ?int $page_id = null, string $type = 'content'): PageAssets
    {

        return DB::transaction(function () use ($file, $path, $page_id, $type) {
            try {
                $imgPath = $this->fileService->saveFile($file, Str::uuid(), $path);
                $urlPath = url($imgPath);

                return PageAssets::create([
                    'url' => $urlPath,
                    'page_id' => $page_id,
                    'type' => $type,
                ]);
            } catch (\Throwable $th) {
                Log::error("[CMSController] Failed to save asset: {$th->getMessage()}");
                throw $th;
            }
        });
    }

    private function handleModuleType() {}
}
