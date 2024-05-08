<?php

namespace App\Http\Controllers;

use App\Http\Requests\Statistics\IncomeStatisicsRequest;
use App\Models\Deals\Deal;
use App\Models\Deals\DealStatus;

class StatisticsController extends Controller
{
    public function allCompletedDeals()
    {
        return response([
            "total" => Deal::where("deal_status_id", DealStatus::getByCode("completed")->id)->count()
        ]);
    }

    public function incomeForPeriod(IncomeStatisicsRequest $request)
    {
        $user = auth()->user();
        $query = Deal::selectRaw("ROUND(SUM(advertisements.cost * deals.percent * 0.01),2) as total")
            ->where('deal_status_id', DealStatus::getByCode('completed')->id);

        if ($request->start_date) $query->where('create_date', '>=', $request->start_date);
        if ($request->end_date)   $query->where('create_date', '<=', $request->end_date);
        if ($user->role->code === 'manager') $query->where('deals.employee_id', $user->id);

        $query->join('advertisements', 'advertisements.id', '=', 'deals.advertisement_id');

        return response([
            "total" => $query->first()->total ?? 0
        ]);
    }
}
