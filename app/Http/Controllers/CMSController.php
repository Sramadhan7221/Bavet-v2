<?php

namespace App\Http\Controllers;

use App\Models\AboutContent;
use App\Models\HomeContent;
use App\Models\Menus;
use App\Models\PageAssets;
use App\Models\Pages;
use App\Services\FileService;
use App\Validators\AboutValidator;
use App\Validators\GalleryValidator;
use App\Validators\HomeValidator;
use App\Validators\MenuValidator;
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

    public function menuList(Request $request) 
    {
        if($request->isMethod('POST')) {
            try {
                $validated = MenuValidator::validate($request,$request->id);
                $sameSlug = Menus::where('slug', $validated['slug'])->count();
                $message = "Menu berhasil ditambahkan, silahkan refresh halaman untuk menampilkan menu pada sidebar";
                $parent = null;

                DB::transaction(function () use($sameSlug,$validated,$request, &$message, &$parent) {
                    if ($sameSlug > 0) {
                        $validated['slug'] = sprintf('%s-%s',$validated['slug'],$sameSlug);
                    }

                    if($request->filled('parent_id') && !is_numeric($request->parent_id)) {
                        $parentMenu = Menus::create([
                            'title' => $request->parent_id,
                            'slug' => Str::slug($request->parent_id),
                            'type' => 'parent',
                            'is_active' => 'true',
                            'created_by' => auth('web')->user()->id
                        ]);
                        $validated['parent_id'] = $parentMenu->id;
                        $parent = ['id' => $parentMenu->id, 'title' => $parentMenu->title];
                    }

                    if($request->filled('id')) {
                        $menu = Menus::where('id', $request->id)
                            ->lockForUpdate()
                            ->first();

                        if($menu->type !== 'parent')
                            $menu->type = $validated['type'];

                        $menu->title = $validated['title'];
                        $menu->external_url = $validated['external_url'];
                        $menu->parent_id = $validated['parent_id'];
                        $menu->is_active = $validated['is_active'];

                        $menu->save();
                        $message = "Berhasil update menu ".$validated['title'];
                    } else {
                        $validated['created_by'] = auth('web')->user()->id;
                        Menus::create($validated);
                    }
                    
                });

                return response()->json(['msg_type' => "success", 'message' => $message, 'with_parent' => $parent]);

            } catch (ValidationException $e) {
                $errors = $e->validator->errors();
                return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
            } catch (\Throwable $th) {
                Log::error('[MenuController] System Error: ' . $th->getMessage() . ' at line ' . $th->getLine());
                return response()->json(['msg_type' => "error", 'message' => 'Terjadi kesalahan. Silahkan coba beberapa saat.'], 500);
            }
        }

        if($request->ajax())
        {
            $parentId = $request->get('parentId', null);

            // Ambil root jika tidak ada parentId, atau anak dari parent tertentu
            $menus = Menus::where('parent_id', $parentId)->orderBy('order_seq')->get();

            $response = $menus->map(function ($menu) {
                return [
                    'title'  => $menu->title,
                    'key'    => (string) $menu->id,  // key harus string
                    'folder' => $menu->type == 'parent', // folder jika punya anak
                    'lazy'   => $menu->type == 'parent', // lazy load anak
                    'slug'   => $menu->slug,
                    'menu_type'   => $menu->type,
                    'menu_id' => $menu->id
                ];
            });

            return response()->json($response);
        }

        return view('admin.menus',[
            'title' => 'Menu Management',
        ]);
    }

    public function searchParent(Request $request)
    {
        $q = strtolower($request->q);
        $data = Menus::where('type','parent')->where(DB::raw("LOWER(title)"),'LIKE',"%$q%")->get(['id','title']);

        return response()->json(['success' => 1, 'msg' => "Berhasil",'data' => $data]);
    }

    public function menuReorder(Request $request)
    {
        $validator = Validator::make($request->all(), ['menu_list' => 'required|array']);
        if ($validator->fails()) {
            return response()->json(['msg' => "Invalid Request", "msg_type" => "error"], 400);
        }

        try {
            DB::transaction(function () use($validator) {
                $validated = $validator->validate();
                $menus = Menus::whereIn('id', $validated['menu_list'])
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');
    
                foreach ($validated['menu_list'] as $index => $itemId) {
                    if (!isset($menus[$itemId])) {
                        throw new \Exception("ID $itemId not found or not accessible.");
                    }
    
                    $menus[$itemId]->update(['order_seq' => $index + 1]);
                }
                
            });

            return response()->json(['msg_type' => "success", 'message' => "Urutan menu berhasil diupdate"]);
        } catch (\Throwable $th) {
            Log::error('[MenuController] System Error: ' . $th->getMessage() . ' at line ' . $th->getLine());
            return response()->json(['msg_type' => "error", 'message' => 'Terjadi kesalahan. Silahkan coba beberapa saat.'], 500);
        }

    }

    public function menuDetail($id)
    {
        $menu = Menus::find($id);
        return response()->json(['data' => $menu]);
    }

    public function menuDelete(Request $request) 
    {
        $validator = Validator::make($request->all(), ['code' => 'required']);
        if ($validator->fails()) {
            return response()->json(['msg' => "Invalid Request", "msg_type" => "error"], 400);
        }
        
        try {
            $id = $request->code;
            $menu = Menus::where('id', $id)
                ->with('children')
                ->first();

            if (!$menu) {
                return response()->json(['msg' => "Gagal dihapus, menu tidak ditemukan. kemungkinan menu telah dihapus", "msg_type" => "warning"], 400);
            }

            if($menu->type == 'parent' && count($menu->children) > 0 ) {
                return response()->json(['msg' => "Gagal dihapus, menu memiliki sub-menu. silahkan hapus sub-menu terkait", "msg_type" => "warning"], 400);
            }

            if(Menus::where('id', $id)->delete())
                return response()->json(['msg' => "Menu berhasil dihapus", "msg_type" => "success"]);
            else
                return response()->json(['msg' => "Menu gagal dihapus", "msg_type" => "warning"]);
            
        } catch (\Throwable $th) {
            Log::error('Kesalahan Sistem: ' . $th->getMessage());
            return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
        }
    }


    public function home(Request $request)
    {
        try {
            if($request->isMethod('POST')) {
                $validated = HomeValidator::validate($request, $request->id);
                if ($request->hasFile('image_hero')) {
                    $image = $request->file('image_hero');
                    $filename = sprintf('home-%s', Str::uuid());
                    $path = $this->fileService->saveFile($image, $filename, 'home');

                    $validated['image_hero'] = url($path);
                }

                if($request->filled('id'))
                    HomeContent::where('id', $request->id)->update($validated);
                else
                    HomeContent::create($validated);

                return response()->json(['msg_type' => "success", 'message' => "success"]);
            }

            return view('admin.home-content',[
                'title' => 'Home Content',
                'content' => HomeContent::first()
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            return response()->json(['msg_type' => "warning", 'message' => $errors], 400);
        } catch (\Throwable $th) {
            Log::error('Kesalahan Sistem: ' . $th->getMessage());
            return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
        }
    }

    public function about(Request $request)
    {
        try {
            if($request->isMethod('POST')) {
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

                if($request->filled('id'))
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
            return view('admin.about-content',[
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
            $asset = $this->saveImageAsset($image,'page-assets',$request->page_id);

            return response()->json(['message' => "Image Uploaded", 'msg_type' => 'success', 'url' => $asset->url ]);

        } catch (ValidationException $e) {
            $message = collect($e->validator->errors()->all())->map(fn($v) => "<p>$v</p>")->implode('');
            return response()->json(['message' => $message, 'msg_type' => 'warning'], 400);
        } catch (\Throwable $th) {
            Log::error('[QuestionBankController] System Error: ' . $th->getMessage() . ' at line ' . $th->getLine());
            return response()->json(['message' => 'Something went wrong. Please try again later.', 'msg_type' => 'error'], 500);
        }
    }

    public function deleteAsset(Request $request) 
    {
        try {
            $request->validate([
                'old_url' => 'required|url'
            ]);

            if($this->fileService->deleteFile($request->old_url)){
                PageAssets::where('url', $request->old_url)->delete();
                return response()->json(['message' => "Berhasil menghapus gambar", 'msg_type' => 'success']);}
            else {
                return response()->json(['message' => "Gagal menghapus gambar", 'msg_type' => 'warning']);}

        } catch (ValidationException $e) {
            $message = collect($e->validator->errors()->all())->map(fn($v) => "<p>$v</p>")->implode('');
            return response()->json(['message' => $message, 'msg_type' => 'warning'], 400);
        } catch (\Throwable $th) {
            Log::error('[QuestionBankController] System Error: ' . $th->getMessage() . ' at line ' . $th->getLine());
            return response()->json(['message' => 'Something went wrong. Please try again later.', 'msg_type' => 'error'], 500);
        }
    }

    public function gallery(Request $request)
    {
        try {

            if ($request->ajax()) {
                $model = Pages::query()
                ->select(['slug', 'banner', 'title','is_active', 'created_at'])->where('type', 'gallery');

                return DataTables::of($model)
                ->addIndexColumn()
                ->editColumn('created_at', function($page) {
                    Carbon ::setLocale('id');
                    $date = Carbon::parse($page->tgl_lacreated_athir);
                    $formattedDate = $date->translatedFormat('d F, Y');
                    return $formattedDate;
                })
                ->make(true);   
            }

            return view('admin.gallery.list',[
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
        
        if($request->isMethod('POST')) {
            try {
                $validated = GalleryValidator::validate($request, $request->id);
                if ($request->hasFile('banner')) {
                    $image = $request->file('banner');
                    $filename = sprintf('gb-%s', Str::uuid());
                    $path = $this->fileService->saveFile($image, $filename, 'gallery-banners');

                    $validated['banner'] = url($path);
                }

                if($request->id) {
                    if(isset($validated['assets']) && is_array($validated['assets'])) {
                        foreach($validated['assets'] as $assetId) {
                            PageAssets::where('url', $assetId)->update(['page_id' => $request->id]);
                        }
                    }

                    if(isset($validated['delete_assets']) && is_array($validated['delete_assets'])) {
                        foreach($validated['delete_assets'] as $assetId) {
                            if($this->fileService->deleteFile($assetId))
                                PageAssets::where('url', $assetId)->delete();
                        }
                    }

                    unset($validated['assets'],$validated['delete_assets']);
                    Pages::where('id', $request->id)->update($validated);
                    $item = Pages::where('id', $request->id)->first();
                    $banner = $item?->banner;
                    $message = "Galeri berhasil diperbarui";
                } else {
                    $validated['slug'] = Str::slug($validated['title']);
                    if(Pages::where('slug', $validated['slug'])->exists()) {
                        $validated['slug'] = sprintf('%s-%s',Str::slug($validated['title']), Pages::where('type','gallery')->count()+1);
                    }

                    $validated['type'] = 'gallery';
                    $validated['created_by'] = auth('web')->user()->id;
                    $validated['is_active'] = 'true';

                    $newItem = Pages::create($validated);
                    if(isset($validated['assets']) && is_array($validated['assets'])) {
                        foreach($validated['assets'] as $assetId) {
                            PageAssets::where('url', $assetId)->update(['page_id' => $newItem->id]);
                        }
                    }

                    $banner = $newItem->banner;
                    $message = "Galeri berhasil ditambahkan";
                }

                return response()->json(['msg_type' => "success", 'message' => $message, 'banner' => $banner ?? '#' ]);
            } catch (\Throwable $th) {
                Log::error('Kesalahan Sistem: ' . $th->getMessage());
                return response()->json(['msg' => "Terjadi Kesalahan", "msg_type" => "error"], 500);
            }
            
        }
        elseif (!$request->isMethod('GET')) {
            abort(405);
        }

        $item = Pages::where('slug', $slug)->first();
        return view('admin.gallery.detail',[
            'title' => $slug ? 'Edit Galeri' : 'Add Galeri',
            'gallery' => $item,
            'assets' => $item ? PageAssets::where('page_id', $item->id)->get('url')->map(fn($value) => $value->url)->toArray() : []
        ]);
        
    }

    public function changeStatus(Request $request)
    {
        try {
            $request->validate([
                'slug' => ['required','string'],
                'is_active' => ['required',Rule::in(['true','false'])]
            ]);

            $page = Pages::where('slug', $request->slug)->first();
            if(!$page) {
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
                'slug' => ['required','string']
            ]);

            $page = Pages::where('slug', $request->slug)->first();
            if(!$page) {
                return response()->json(['msg_type' => "warning", 'message' => "Data tidak ditemukan"], 404);
            }

            DB::transaction(function () use($page) {
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

    private function handleModuleType()
    {

    }
}
