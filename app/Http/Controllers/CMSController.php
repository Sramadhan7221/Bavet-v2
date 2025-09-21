<?php

namespace App\Http\Controllers;

use App\Models\HomeContent;
use App\Models\Menus;
use App\Services\FileService;
use App\Validators\HomeValidator;
use App\Validators\MenuValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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

    private function handleStaticType()
    {
        
    }

    private function handleModuleType()
    {

    }
}
