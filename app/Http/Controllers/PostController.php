<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Fetch all posts
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $posts = $this->post->with('user')
            ->filterByPublicationDate($request->publication_date)
            ->paginate(10);

        return $this->successResponse('success', PostResource::collection($posts)->response());
    }

    /**
     * Fetch only post belonging to a user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myPost(): \Illuminate\Http\JsonResponse
    {
        $posts = $this->post->where('user_id', auth()->user()->id)
            ->latest()
            ->paginate(10);

        return $this->successResponse('success', PostResource::collection($posts)->response());
    }


    public function create(CreatePostRequest $request)
    {
        $payload = collect($request->validated())->merge(['user_id' => auth()->user()->id])->all();

        $post = $this->post->create($payload);

        return $this->createdResponse('Post created successfully', $post);
    }
}
