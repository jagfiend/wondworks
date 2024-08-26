<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

final class ShowController extends Controller
{
    public function __invoke(Post $post): View
    {
        abort_if(! $post->date_published, 404);

        return view('posts.show', compact('post'));
    }
}
