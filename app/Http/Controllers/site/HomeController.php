<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function __construct(private readonly Post $post)
    {
    }

    public function index()
    {
        $recentPosts = $this->post
            ->with(['images' => function (Builder $query) {
                $query->where('position', 1)
                      ->select(['id', 'post_id', 'file_path', 'thumbnail_path']);
            }])
            ->select(['id', 'title'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('site.home.index', ['recentPosts' => $recentPosts]);
    }
}
