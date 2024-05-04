<?php

namespace App\Http\Requests\Document;

use App\Http\Requests\ApiRequest;

class DocumentUploadRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'documents'                => 'required|array',
            'documents.*'              => 'required|file|max:10240|mimes:jpeg,jpg,png,pdf,docx'
        ];
    }
}
