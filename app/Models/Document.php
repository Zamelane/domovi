<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;
    public $timestamps = false;

    // Заполняемые поля
    protected $fillable = [
        'id',
        'deal_id',
        'path'
    ];

    /**
     * Проверяет, имеет ли пользователь отношение к сделке документа
     * @param $userId
     * @return bool
     */
    public function checkRelation($userId)
    {
        $deal = $this->deal;
        return $deal->checkRelation($userId);
    }

    public static function uploadDocumentsFromRequest(int $dealId)
    {
        $files = request()->file('documents') ?? [];

        foreach ($files as $file) {
            $fileExt = $file->getClientOriginalExtension();
            $fileHash = md5_file($file->getRealPath());

            $imageName = "$fileHash.$fileExt";
            $path = "uploads/documents/$fileExt/";

            if (!Storage::exists($path.$imageName))
                $file->move  ($path,$imageName );

            Document::firstOrCreate(["path" => $imageName, "deal_id" => $dealId]);
        }
    }

    // Связи
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }
}
