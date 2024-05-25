<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\UserWebsite;
use App\Models\Website;
use Illuminate\Support\Facades\DB;

class WebsiteService
{
    public static function isUserExists(int $userId): bool
    {
        return (bool) User::where('id', $userId)->exists();
    }

    public static function isWebsiteExists(int $websiteId): bool
    {
        return (bool) Website::where('id', $websiteId)->exists();
    }

    /**
     * @throws \Exception
     */
    public static function subscribeWebsite(array $payload): void
    {
        try {
            DB::transaction(function () use ($payload) {
                UserWebsite::create($payload);
            });
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
