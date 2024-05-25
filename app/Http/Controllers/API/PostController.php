<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Services\PostService;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function create(CreatePostRequest $request): JsonResponse
    {
        if (!PostService::isWebsiteExists(websiteId: $request->website_id)) {
            return $this->responseError(message: 'Website not found', code: 201);
        }

        try {
            PostService::createPost(payload: $request->all());
            PostService::notify();
        } catch (\Exception $e) {
            return $this->responseError(message: 'Internal server error');
        }

        return $this->responseSuccess(message: 'Post created successfully');
    }
}
