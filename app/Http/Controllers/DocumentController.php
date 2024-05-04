<?php

namespace App\Http\Controllers;

use App\Exceptions\ForbiddenForYouException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\Document\DocumentUploadRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Deal;
use App\Models\Document;

class DocumentController extends Controller
{
    public function download(int $id)
    {
        if (!$document = Document::find($id))
            throw new NotFoundException("Document");

        $user = auth()->user();

        if (!$document->checkRelation($user->id)
            && $user->role->code !== "admin")
            throw new ForbiddenForYouException();

        $extKeys = explode(".", $document->path);
        $ext = $extKeys[count($extKeys) - 1];

        return response()->file("uploads/documents/$ext/$document->path");
    }

    public function upload(DocumentUploadRequest $request, int $dealId)
    {
        if (!$deal = Deal::find($dealId))
            throw new NotFoundException("Deal");

        $user = auth()->user();

        if ($deal->employee_id !== $user->id
            && $user->role->code !== "admin")
            throw new ForbiddenForYouException();

        Document::uploadDocumentsFromRequest($dealId);

        return response(null, 201);
    }

    public function all(int $dealId)
    {
        if (!$deal = Deal::find($dealId))
            throw new NotFoundException("Deal");

        $user = auth()->user();

        if (!$deal->checkRelation($user->id) && $user->role->code !== "admin")
            throw new ForbiddenForYouException();

        return response(DocumentResource::collection(Document::where("deal_id", $deal->id)->get()), 200);
    }
}
