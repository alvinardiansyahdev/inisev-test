<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use App\Http\Services\WebsiteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function subscribe(SubscriptionRequest $request): JsonResponse
    {
        if (!WebsiteService::isUserExists(userId: $request->user_id)) {
            return $this->responseError(message: 'User not found', code: 201);
        }

        if (!WebsiteService::isWebsiteExists(websiteId: $request->website_id)) {
            return $this->responseError(message: 'Website not found', code: 201);
        }

        try {
            WebsiteService::subscribeWebsite(payload: $request->all());
        } catch (\Exception $e) {
            return $this->responseError(message: 'Internal server error');
        }

        return $this->responseSuccess(message: 'Website subscribed');
    }
}
