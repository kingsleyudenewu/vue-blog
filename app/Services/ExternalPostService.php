<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ExternalPostService
{
    /**
     * @return mixed
     */
    public function execute(): mixed
    {
        $response = Http::get(config('services.square_one.url'))->json();

        if (Arr::get($response, 'status') !== 'ok') {
            abort(400, 'Could not fetch new blog posts');
        }

        $posts = $this->formatNewPost(Arr::get($response, 'articles'));

        return Post::insert($posts);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function formatNewPost(array $data): array
    {
        $userId = User::admin()->value('id');

        return collect($data)->map(function ($value) use ($userId) {
            return [
                'title' => Arr::get($value, 'title'),
                'description' => Arr::get($value, 'description'),
                'published_at' => Carbon::parse(Arr::get($value, 'publishedAt'))->toDateTimeString(),
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->all();
    }
}
