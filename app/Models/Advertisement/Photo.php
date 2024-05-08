<?php

namespace App\Models\Advertisement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "name",
        "advertisement_id"
    ];

    protected $hidden = [
        "id",
        "advertisement_id"
    ];

    public static function saveFromRequestByAdvertisementId(int $advertisementId)
    {
        $files = request()->file('photos') ?? [];

        foreach ($files as $file) {
            $fileExt = $file->getClientOriginalExtension();
            $fileHash = md5_file($file->getRealPath());

            $imageName = "$fileHash.$fileExt";
            $path = "public/$fileExt/";

            if (!Storage::exists($path.$imageName))
                $file->storeAs($path,$imageName);

            Photo::firstOrCreate(["name" => $imageName, "advertisement_id" => $advertisementId]);
        }
    }

    public static function deleteNotIn(array $names, $advertisementId)
    {
        Photo::whereNotIn("name", $names)->where("advertisement_id", $advertisementId)->delete();
    }
}
