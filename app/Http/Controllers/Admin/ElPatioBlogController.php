<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ElPatioPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ElPatioBlogController extends Controller
{
    public function edit(Request $request)
    {
        // One-time import: if DB empty but session has posts, import them
        $dbCount = ElPatioPost::count();
        $sessionPosts = session('elpatio_blog_posts', []);
        if ($dbCount === 0 && ! empty($sessionPosts)) {
            foreach ($sessionPosts as $sp) {
                ElPatioPost::create([
                    'title' => $sp['title'] ?? 'Untitled',
                    'excerpt' => $sp['excerpt'] ?? null,
                    'body' => $sp['body'] ?? null,
                    'featured_image' => $sp['featured_image'] ?? null,
                    'published_at' => now(),
                ]);
            }
            session()->forget('elpatio_blog_posts');
        }

        $posts = ElPatioPost::orderByDesc('created_at')->get()->map->toArray()->toArray();

        return view('admin.pages.edit-elpatio-blog', ['posts' => $posts]);
    }

    public function create()
    {
        return view('admin.pages.create-elpatio-blog');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'excerpt'         => 'nullable|string',
            'body'            => 'nullable|string',
            'featured_image'  => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $allowed = ['p','br','strong','em','b','i','u','ul','ol','li','a','h1','h2','h3','h4','blockquote','img','figure','figcaption','span','div'];
        $body = isset($data['body']) ? strip_tags($data['body'], $allowed) : null;

        $payload = [
            'title'        => $data['title'],
            'excerpt'      => $data['excerpt'] ?? null,
            'body'         => $body,
            'published_at' => $request->boolean('is_published') ? now() : null,
        ];

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('elpatio/blog', 'public');
            $payload['featured_image'] = $path;
        }

        ElPatioPost::create($payload);

        $label = $request->boolean('is_published') ? 'publicada' : 'guardada como borrador';
        return redirect()->route('admin.pages.edit-elpatio-blog')->with('success', "Entrada {$label}.");
    }

    public function editItem(Request $request, $id)
    {
        $post = ElPatioPost::find($id);
        if (! $post) {
            return redirect()->route('admin.pages.edit-elpatio-blog')->with('error', 'Entrada no encontrada');
        }
        return view('admin.pages.edit-elpatio-blog-edit', ['post' => $post->toArray()]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'slug'           => 'nullable|string|max:255',
            'excerpt'        => 'nullable|string',
            'body'           => 'nullable|string',
            'featured_image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $post = ElPatioPost::find($id);
        if (! $post) {
            return redirect()->route('admin.pages.edit-elpatio-blog')->with('error', 'Entrada no encontrada');
        }

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('elpatio/blog', 'public');
            $post->featured_image = $path;
        }

        $post->title   = $data['title'];
        $post->excerpt = $data['excerpt'] ?? null;

        // Update slug only if explicitly provided and not empty
        if (!empty($data['slug'])) {
            $post->slug = Str::slug($data['slug']);
        }

        // Handle publish/unpublish toggle
        $wantPublished = $request->boolean('is_published');
        if ($wantPublished && empty($post->published_at)) {
            $post->published_at = now();
        } elseif (! $wantPublished) {
            $post->published_at = null;
        }

        $allowed = ['p','br','strong','em','b','i','u','ul','ol','li','a','h1','h2','h3','h4','blockquote','img','figure','figcaption','span','div'];
        $post->body = isset($data['body']) ? strip_tags($data['body'], $allowed) : null;
        $post->save();

        return redirect()->route('admin.pages.edit-elpatio-blog')->with('success', 'Entrada actualizada.');
    }

    public function destroy(Request $request, $id)
    {
        $post = ElPatioPost::find($id);
        if ($post) {
            $post->delete();
        }
        return redirect()->route('admin.pages.edit-elpatio-blog')->with('success', 'Entrada eliminada');
    }

    /**
     * Handle Trix attachment uploads from the admin editor.
     * Expects a multipart POST with a file field named 'file'.
     * Returns JSON: { url: 'https://.../storage/...' }
     */
    public function uploadTrix(Request $request)
    {
        // Basic auth check: ensure user is authenticated and can access admin pages.
        if (! $request->user()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        try {
            $validated = $request->validate([
                'file' => 'required|file|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            ]);

            $file = $request->file('file');
            // Log upload attempt
            logger()->info('Trix upload attempt', [
                'user_id' => $request->user()->id,
                'user_email' => $request->user()->email,
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getClientMimeType(),
            ]);

            $path = $file->store('elpatio/uploads', 'public');

            // Return the full URL usable by the client
            $url = asset('storage/' . $path);

            return response()->json(['url' => $url], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            logger()->error('Trix upload failed', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Upload failed', 'error' => $e->getMessage()], 500);
        }
    }
}
