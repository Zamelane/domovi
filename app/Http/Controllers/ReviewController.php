<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\ForbiddenForYouException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\Review\ReviewCreateRequest;
use App\Http\Requests\Review\ReviewEditRequest;
use App\Http\Requests\Review\ReviewSearchRequest;
use App\Http\Requests\Review\ReviewSetModeratedStatusRequest;
use App\Http\Resources\Reviews\ReviewMinResource;
use App\Http\Resources\Reviews\ReviewResource;
use App\Models\Advertisement;
use App\Models\Review;

class ReviewController extends Controller
{
    public function create(ReviewCreateRequest $request)
    {
        $user = auth()->user();

        if (!$advertisement = Advertisement::find($request->advertisement_id))
            throw new NotFoundException('Advertisement');

        $isService = $advertisement->checkIsServices($user->id);

        if (Review::where([
                ['advertisement_id', '=', $advertisement->id],
                ['user_id', '=', $user->id]
            ]))
            throw new ApiException(400, 'Have you already left a review for this ad');

        $review = Review::create([
            ...request(['advertisement_id', 'stars', 'description']),
            'create_datetime' => date('Y-m-d'),
            'update_datetime' => null,
            'is_moderation' => null,
            'is_services' => $isService,
            'user_id' => $user->id
        ]);

        return response([
            'id' => $review->id
        ], 201);
    }

    public function list(int $advId)
    {
        if (!Advertisement::find($advId))
            throw new NotFoundException('Advertisement');

        $query = Review::where('advertisement_id', $advId)->where(function ($q) {
                $q->where('is_moderation', true)->orWhere('user_id', auth()->user()->id);
            });
        return response([
            'reviews' => ReviewMinResource::collection($query->simplePaginate(15)),
            "allPages" => ceil($query->count() / 15)
        ],200);
    }

    public function listMe()
    {
        $query = Review::where('user_id', auth()->user()->id);
        return response([
            'reviews' => ReviewMinResource::collection($query->simplePaginate(15)),
            "allPages" => ceil($query->count() / 15)
        ], 200);
    }

    public function awaitModeratedList()
    {
        $query = Review::where('is_moderation', null);
        return response([
            'reviews' => ReviewMinResource::collection($query->simplePaginate(15)),
            "allPages" => ceil($query->count() / 15)
        ], 200);
    }

    public function delete(int $id)
    {
        if (!$review = Review::find($id))
            throw new NotFoundException('Review');

        $user = auth()->user();

        if ($review->user_id !== $user->id
            /*&& ($review->is_moderation === true && $user->role->code !== 'manager')
            && $user->role->code !== 'admin'*/)
            return new ForbiddenForYouException();

        $review->delete();

        return response(null, 200);
    }

    public function edit(ReviewEditRequest $request, int $id)
    {
        if (!$review = Review::find($id))
            throw new NotFoundException('Review');

        $user = auth()->user();

        if ($review->user_id !== $user->id
            /*&& ($review->is_moderation === true && $user->role->code !== 'manager')
            && $user->role->code !== 'admin'*/)
            return new ForbiddenForYouException();

        $review->update([...request(['stars', 'description'])]);

        return response(null, 200);
    }

    public function search(ReviewSearchRequest $request)
    {
        $query = Review::query();

        if ($userId = $request->user_id)
            $query->where('user_id', $userId);

        if ($isModeration = $request->is_moderation)
            $query->where('is_moderation', $isModeration);

        return response([
            'reviews' => ReviewMinResource::collection($query->simplePaginate(15)),
            "allPages" => ceil($query->count() / 15)
        ], 200);
    }

    public function setModeratedStatus(ReviewSetModeratedStatusRequest $request, int $id)
    {
        if (!$review = Review::find($id))
            throw new NotFoundException('Review');

        $review->update([...request(['is_moderation'])]);

        return response(null, 200);
    }

    public function show(int $id)
    {
        if (!$review = Review::find($id))
            throw new NotFoundException('Review');

        return response(ReviewResource::make($review), 200);
    }
}
