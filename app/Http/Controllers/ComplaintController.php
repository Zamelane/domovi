<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\Complaint\ComplaintCreateRequest;
use App\Http\Requests\Complaint\ComplaintReviewRequest;
use App\Http\Resources\Complaint\ComplaintResource;
use App\Models\Complaint;

class ComplaintController extends Controller
{
    public function create(ComplaintCreateRequest $request)
    {
        $user = auth()->user();

        if ($complaint = Complaint::where('user_id', $user->id)
            ->where('advertisement_id', $request->advertisement_id)->first())
            throw new ApiException(400, "You have already left a complaint about this ad");

        $complaint = Complaint::create([
            ...request(['advertisement_id', 'description']),
            'user_id' => $user->id,
            'is_review' => false
        ]);

        return response([
            'id' => $complaint->id
        ], 200);
    }

    public function awaitModeratedList()
    {
        $query = Complaint::where('is_review', false);
        return response([
            'complaints' => ComplaintResource::collection($query->simplePaginate(15)),
            "allPages" => ceil($query->count() / 15)
        ], 200);
    }

    public function review(ComplaintReviewRequest $request, int $id)
    {
        if (!$complaint = Complaint::find($id))
            throw new NotFoundException('Complaint');

        if ($complaint->is_review)
            throw new ApiException(400, 'The complaint has already been considered');

        if ($request->ban_ad_author)
            $complaint->advertisement->user->update(['is_banned' => true]);

        if ($request->ban_complaint_author)
            $complaint->user->update(['is_banned' => true]);

        switch ($request->ad_action) {
            case 'delete':
                $complaint->advertisement->update(['is_deleted' => true]);
                break;
            case 'set_no_active':
                $complaint->advertisement->update(['is_active' => false]);
                break;
        }

        $complaint->update(['is_review' => true]);

        return response(null, 200);
    }
}
