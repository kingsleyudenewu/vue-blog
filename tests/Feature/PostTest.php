<?php

uses()->group('posts');

use App\Models\Post;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use function Pest\Faker\faker;


test('display all random post', function () {
    createUserWithPosts();

    $this->json('GET', url('/api/v1/posts'))
        ->assertStatus(200)
        ->assertJsonFragment([
            "status" => "success",
            'message' => 'success'
        ]);
});

test('user can create a post', function () {
    $user = createUser();

    $payload = [
        'user_id' => $user->id,
        'title' => faker()->title,
        'description' => faker()->realText
    ];

    actingAs()
        ->json('POST', url('/api/v1/posts'), $payload)
        ->assertStatus(201)
        ->assertJsonFragment([
            "status" => "success",
            'message' => 'Post created successfully'
        ]);
});

test('admin can pull external post', function () {

    $persistData = persistExternalPostData();

    Http::fake([
        config('services.square_one.url') => Http::sequence()->push($persistData),
    ]);

    Artisan::call('external-post:import');

    $postData = Post::latest()->first();

    expect($postData->title)->toBeString()->not->toBeEmpty();
    expect($postData->description)->toBeString()->not->toBeEmpty();

    $this->assertEquals($postData->title, $persistData['articles'][0]['title']);
    $this->assertEquals($postData->description, $persistData['articles'][0]['description']);

});
