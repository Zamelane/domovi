<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Office\OfficeCreateRequest;
use App\Http\Requests\Office\OfficeEditRequest;
use App\Http\Resources\Offices\OfficeResource;
use App\Models\Office\Day;
use App\Models\Office\Office;

class OfficeController extends Controller
{
    public function get()
    {
        return response(OfficeResource::collection(
            Office::where("is_active", true)->get()
        ), 200);
    }

    public function create(OfficeCreateRequest $request)
    {
        $office = Office::create(request([
            "name",
            "is_active",
            "address_id"
        ]));

        if ($workDays = $request->work_days)
            foreach ($workDays as $day)
                Day::create([
                    "code" => $day["code"],
                    "open_time" => $day["open_time"],
                    "close_time" => $day["close_time"],
                    "office_id" => $office->id
                ]);

        return response(null, 201);
    }

    public function edit(OfficeEditRequest $request, int $id)
    {
        if (!$office = Office::find($id))
            throw new NotFoundException("Office");

        $office->update(request([
            "name",
            "is_active",
            "address_id"
        ]));

        if ($workDays = $request->work_days) {
            foreach ($workDays as $day) {
                if (!$day) continue;
                $days[] = $day["code"];
                Day::firstOrCreate([
                    "code" => $day["code"],
                    "open_time" => $day["open_time"],
                    "close_time" => $day["close_time"],
                    "office_id" => $office->id
                ]);
            }
            Day::where("office_id", $office->id)
                ->whereNotIn("code", $days ?? [])->delete();
        }

        return response(null, 200);
    }
}
