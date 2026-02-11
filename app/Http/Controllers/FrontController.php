<?php

namespace App\Http\Controllers;

use App\Models\AboutContent;
use App\Models\CarouselBanner;
use App\Models\HomeContent;
use App\Models\Karyawan;
use App\Models\Pages;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Testimonial;
use App\Services\BlogService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {

        $hc = HomeContent::first();
        $galleries = Pages::where('type', 'gallery')
            ->where('is_active', 'true')
            ->with('assets')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        $blogs = Pages::where('type', 'blog')
            ->where('is_active', 'true')
            ->with('penulis')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        
        $services = Service::all();
        $carousels = CarouselBanner::where('status', 'active')
            ->orderBy('urutan')
            ->get();
        $testi_list = Testimonial::orderByDesc('created_at')->limit(10)->get();
        $partners = Partner::orderByDesc('created_at')->limit(10)->get();

        return view('beranda', compact(['hc','galleries','blogs', 'services', 'carousels', 'testi_list', 'partners']));
    }

    public function blogSearch(Request $request)
    {
        $query = request()->input('query');
        $tag = request()->input('tag');
        $breadcrumb = [
            ['current' => false, 'title' => 'Beranda', 'url' => route('beranda')],
            ['current' => true, 'title' => 'Artikel', 'url' => route('artikel.cari')],
        ];

        $artikels = Pages::where('type', 'blog')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQ) use ($query) {
                    $subQ->where(DB::raw('LOWER(title)'), 'like', '%' . strtolower($query) . '%');
                    $terms = explode(' ', strtolower($query));
                    foreach ($terms as $term) {
                        $subQ->orWhere(DB::raw('LOWER(title)'), 'like', '%' . strtolower($term) . '%');
                    }
                });
            })
            ->when($tag, function ($q) use ($tag) {
                $q->whereHas('tags', function ($tagQ) use ($tag) {
                    $tagQ->where('tag_name', $tag);
                });
            })
            ->with(['penulis', 'tags'])
            ->orderByDesc('created_at')
            ->paginate(5)
            ->withQueryString();

        return view('blog-list', compact(['breadcrumb', 'query', 'tag', 'artikels']));
    }

    public function blog(Request $request)
    {
        $slug = $request->input('page');
        
        // Return 404 if no slug provided
        if (!$slug) {
            abort(404);
        }

        // Fetch the page post
        $currentPost = Pages::where('slug', $slug)->with(['penulis', 'tags'])->first();
        
        // Return 404 if post not found
        if (!$currentPost) {
            abort(404);
        }

        // Set locale for date formatting
        Carbon::setLocale('id');

        // Process content based on post type
        $this->processPostContent($currentPost);

        // Get hero image
        $heroImg = $this->getHeroImage($currentPost);

        // Format article date
        $tanggalArtikel = Carbon::parse($currentPost->created_at)->translatedFormat('d F Y');

        // Build breadcrumb
        $breadcrumb = $this->buildBreadcrumb($currentPost);

        // Fetch latest posts
        $latestPost = Pages::where('type', 'blog')
            ->with(['penulis', 'tags'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('blog', [
            'breadcrumb' => $breadcrumb,
            'img_hero' => $heroImg,
            'penulis' => $currentPost->penulis,
            'tgl' => $tanggalArtikel,
            'tags' => $currentPost->tags,
            'post' => $currentPost,
            'latest_post' => $latestPost,
        ]);
    }

    /**
     * Process and format post content
     */
    private function processPostContent(Pages $post): void
    {
        $content = BlogService::setContent(
            [$post->title],
            ['', $post->content]
        );
        
        $post->content = $content['content'];
        $post->title = $content['title'];

        // If this is the about page, merge with AboutContent
        if ($post->slug === 'about') {
            $this->mergeAboutContent($post);
        }
    }

    /**
     * Merge about content with page content
     */
    private function mergeAboutContent(Pages $post): void
    {
        $about = AboutContent::query()
            ->select(['title', 'desc', 'sejarah', 'tugas_fungsi'])
            ->first();

        if (!$about) {
            return;
        }

        $setContent = BlogService::setContent(
            [$post->title, $about->title, 'Sejarah', 'Tugas dan Fungsi'],
            ['', $about->desc, $about->sejarah, $about->tugas_fungsi]
        );

        $post->content = $setContent['content'];
        $post->title = $setContent['title'];
    }

    /**
     * Get hero image for the post
     */
    private function getHeroImage(Pages $post): string
    {
        if ($post->slug === 'about') {
            $about = AboutContent::query()->select(['image_hero'])->first();
            if ($about?->image_hero) {
                return $about->image_hero;
            }
        }

        return $post->banner ?? asset('admin/images/bavet.png');
    }

    /**
     * Build breadcrumb navigation
     */
    private function buildBreadcrumb(Pages $post): array
    {
        return [
            ['current' => false, 'title' => 'Beranda', 'url' => route('beranda')],
            ['current' => true, 'title' => $post->title, 'url' => '#'],
        ];
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
