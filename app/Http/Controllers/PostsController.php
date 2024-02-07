<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PostsRepository;

class PostsController extends Controller
{

    public function __construct(
        protected PostsRepository $postsRepository,
    )
    {
    }

    function __invoke()
    {
        $posts = $this->postsRepository->all();

        return view('posts.index', ['posts' => $posts]);
    }

}
