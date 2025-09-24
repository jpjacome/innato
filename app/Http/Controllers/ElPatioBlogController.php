<?php
namespace App\Http\Controllers;

use App\Models\ElPatioPost;
use Illuminate\Http\Request;

class ElPatioBlogController extends Controller
{
    public function index()
    {
    $posts = ElPatioPost::orderByDesc('published_at')->paginate(6);
    return view('elpatio.blog-index', ['posts' => $posts]);
    }

    public function show($slug)
    {
        $post = ElPatioPost::where('slug', $slug)->firstOrFail();
        return view('elpatio.single-blog-post', ['post' => $post->toArray()]);
    }
}
