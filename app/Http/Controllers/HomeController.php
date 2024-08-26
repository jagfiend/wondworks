<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

final class HomeController extends Controller
{
    public function __invoke(): View
    {
        $posts = Post::query()
            ->select([
                'id',
                'title',
                'content',
                'date_published',
            ])
            ->whereNotNull('date_published')
            ->latest('date_published')
            ->get();

        return view('home', compact('posts'));
    }
}
