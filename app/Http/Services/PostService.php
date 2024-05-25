<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Models\User;
use App\Models\Website;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class PostService
{
    public static function isWebsiteExists(int $websiteId): bool
    {
        return (bool) Website::where('id', $websiteId)->exists();
    }

    /**
     * @throws \Exception
     */
    public static function createPost(array $payload): Post
    {
        $post = null;
        try {
            DB::transaction(function () use (&$post, $payload) {
                $post = Post::create($payload);
            });

            return $post;
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            DB::rollback();

            throw $e;
        }
    }

    public static function notify(): void
    {
        dispatch(function () {
            Artisan::call('subscribers:notify');
        })->afterResponse();
    }
}
