<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "user_id",
        "advertisement_id",
        "address_id",
        "advertisement_type_id",
        "transaction_type",
        "area",
        "count_rooms",
        "measurement_type",
        "is_active",
        "is_moderated",
        "is_deleted",
        "is_archive",
        "cost"
    ];

    /**
     * Проверяет, получал ли пользователь услугу.
     * @param int $userId
     * @return bool
     */
    public function checkIsServices(int $userId): bool
    {
        $advertisementId = $this->id;
        $deal = Deal::where([
            ['advertisement_id', '=', $advertisementId],
            ['user_id', '=', $userId]
        ])->exists();

        return $deal;
    }

    /*
     * Создаёт и возвращает объявление по полям из запроса.
     */
    public static function createByRequest()
    {
        $currUser = auth()->user();
        $addressId = Address::addresByRequest()->id;

        return Advertisement::create([
            ...request()->all(),
            'advertisement_type_id' => request()->advertisement_type_id,
            'address_id' => $addressId,
            'user_id' => $currUser->id
        ]);
    }

    public static function checkEmployeeRelationsByAdvertisement(int $employeeId, int $advertisementId)
    {
        $deal = Deal::where("advertisement_id", $advertisementId)->first();

        if (!$deal || $deal->employee_id != $employeeId)
            return false;
        return true;
    }

    public function checkAvailable()
    {
        if ($this->advertisement_id !== null
            || !$this->is_moderated
            || $this->is_deleted
            || $this->is_achive)
            return false;
        return true;
    }

    // Связи
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function advertisement_type()
    {
        return $this->belongsTo(AdvertisementType::class);
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
    public function ad_filter_values()
    {
        return $this->hasMany(AdFilterValue::class);
    }
}
