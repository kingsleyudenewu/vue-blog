<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use App\Models\Post;
use App\Models\User;

uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}

function userLogin($user = null) {
    return test()->actingAs($user ?? User::factory()->create());
}

function persistUser(){
    return User::factory()->make();
}

function createUser() {
    return User::factory()->create([
        'password' => 'password'
    ]);
}

function createAdminPosts() {
    $user = User::factory()->adminRole()->create();

    return Post::factory()
        ->count(3)
        ->for($user)
        ->create();
}

function persistAdminPosts() {
    $user = User::factory()->adminRole()->create();

    return Post::factory()
        ->count(3)
        ->for($user)
        ->make();
}

function createUserWithPosts() {
    return User::factory()
        ->has(Post::factory()->count(3))
        ->create();
}

function actingAs(string $driver = null)
{
    return test()->actingAs(User::factory()->create(), $driver);
}

function persistExternalPostData() {

    $persistData = persistAdminPosts();

    return [
        'status' => 'ok',
        'count' => $persistData->count(),
        'articles' => $persistData->toArray()
    ];
}
