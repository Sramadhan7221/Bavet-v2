<?php

namespace App\Http\Controllers;

use App\Models\AboutContent;
use App\Models\HomeContent;
use App\Models\Pages;
use App\Services\BlogService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {

        $galleries = Pages::where('type', 'gallery')
            ->where('is_active', 'true')
            ->with('assets')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('home',[
            'hc' => HomeContent::first(),
            'about' => AboutContent::first(),
            'galleries' => $galleries
        ]);
    }

    public function blog(Request $request)
    {
        $slug = $request->get('page');
        $tag = $request->get('tag');
        $search = $request->get('search');
        $breadcrumb = [
            // ['current' => false, 'title' => "Beranda", 'url' => route('beranda')],
            // ['current' => true, 'title' => "Tentang kami", 'url' => '#']
        ];

        if($slug) {
            $currentPost = Pages::where('slug', $slug)->with(['penulis','tags'])->first();
            $heroImg = asset('admin/images/bavet.png'); 
            Carbon::setLocale('id');
            $tanggalArtikel = Carbon::parse($currentPost->created_at)->translatedFormat('d F Y');
            $breadcrumb = [
                ['current' => false, 'title' => "Beranda", 'url' => route('beranda')],
                ['current' => true, 'title' => "Tentang kami", 'url' => '#']
            ];
            if($slug === "about") {
                $about = AboutContent::query()->select(['title','desc','sejarah','tugas_fungsi'])->first();
                $heroImg = $about->image_hero ?? $heroImg;
                $setContent = BlogService::setContent(
                    [$currentPost->title,$about->title,'Sejarah','Tugas dan Fungsi'],
                    ['',$about->desc, $about->sejarah, $about->tugas_fungsi]
                );
                $currentPost->content = $setContent['content'];
                $currentPost->title = $setContent['title'];
            }

            $latestPost = Pages::where('type', 'blog')
                ->with(['penulis','tags'])
                ->orderByDesc('created_at')
                ->take(5)
                ->get();
                
            return view('blog',[
                'breadcrumb' => $breadcrumb,
                'img_hero' => $heroImg,
                'penulis' => $currentPost->penulis, 
                'tgl' => $tanggalArtikel,
                'tags' => $currentPost->tags,
                'post' => $currentPost,
                'latest_post' => $latestPost
            ]);
        }

        // $artikelList = Pages::where('type', 'blog')
        //     ->with('penulis')
        //     ->orderByDesc('created_at')
        //     ->paginate(5);
            
        // dd($tag);
        
    }

    public function gallery($page)
    {
        $page = Pages::where('slug', $page)->with('assets')->first();
        if(!$page) {
            return abort(404);
        }

        $breadcrumb = [
            ['current' => false, 'title' => "Beranda", 'url' => route('beranda')],
            ['current' => true, 'title' => $page->title, 'url' => route('galeri.detail', ['page' => $page->slug])]
        ];
        
        return view('gallery',[
            'breadcrumb' => $breadcrumb,
            'assets' => $page->assets->map(fn($value) => $value->url)->toArray(),
            'gallery_title' => $page->title,
            'desc' => $page->content
        ]);

    }
}
