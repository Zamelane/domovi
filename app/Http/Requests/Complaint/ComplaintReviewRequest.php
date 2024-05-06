<?php

namespace App\Http\Requests\Complaint;

use App\Http\Requests\ApiRequest;

class ComplaintReviewRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'ad_action' => 'required|in:delete,set_no_active,none',
            'ban_ad_author' => 'required|boolean',
            'ban_complaint_author' => 'required|boolean'
        ];
    }
}
