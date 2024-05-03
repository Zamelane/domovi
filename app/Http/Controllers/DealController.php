<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\ForbiddenForYouException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\Deal\DealCreateRequest;
use App\Http\Requests\Deal\DealEditRequest;
use App\Http\Resources\Deals\DealResource;
use App\Http\Utils\RulesChecker;
use App\Models\Address;
use App\Models\Advertisement;
use App\Models\Deal;
use App\Models\DealStatus;

class DealController extends Controller
{
    /**
     * Отдаёт информацию о сделке по id.
     * Пользователь должен иметь отношение к
     * сдеке или быть админом.
     * @param int $dealId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     * @throws ForbiddenForYouException
     * @throws NotFoundException
     */
    public function show(int $dealId)
    {
        // Если сделки не существует, выкидываем ошибку
        if(!$deal = Deal::find($dealId))
            throw new NotFoundException("Deal");

        // Получаем данные о пользователе
        $user = auth()->user();
        $userId = $user->id;

        // Если пользователь не имеет отношения к сделке и он не админ, то выкидываем ошибку
        if ($deal->user_id !== $userId
            && $deal->employee_id !== $userId
            && $user->role->code !== "admin")
            throw new ForbiddenForYouException();

        return response(DealResource::make($deal), 200);
    }

    /**
     * Оформляет сделку на объявлении
     * @param DealCreateRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     * @throws ForbiddenForYouException
     * @throws NotFoundException
     */
    public function create(DealCreateRequest $request)
    {
        // Получаем входные данные
        $user = auth()->user();

        // Если объявления не существует, то выкидываем ошибку
        if (!$advertisement = Advertisement::find($request->advertisement_id))
            throw new NotFoundException("Advertisement");

        // Если автор объявления открывает сделку для самого себя, то выкидываем ошибку
        if ($advertisement->user->id === $user->id)
            throw new ForbiddenForYouException("You can't make an order from yourself");

        // Если адреса не существет, то выкидываем ошибку
        if (!Address::find($request->address_id))
            throw new NotFoundException("Address");

        // Если объявление не доступно для оформления, то выкидываем ошибку
        if (!$advertisement->checkAvailable())
            throw new ApiException(401, "The advertisement is not available for registration");

        // Запрещаем работникам оформлять сделки
        if (array_search($user->role->code, ["owner", "user"]) === false)
            throw new ForbiddenForYouException();

        // Если идёт аренда, то обязательна дата желаемого заезда и выезда
        if ($advertisement->transaction_type === "order")
            RulesChecker::check([
                'start_date'        => 'required|date|date_format:Y-m-d|after:today',
                'valid_until_date'  => 'date|date_format:Y-m-d|after:start_at'
            ]);

        // Создаём копию для заказа
        $orderAdvertisement = $advertisement->replicate();
        // Указываем ссылку на оригинал
        $orderAdvertisement->advertisement_id = $advertisement->id;
        $orderAdvertisement->save();

        // Создаём сделку
        $deal = Deal::create([
            'user_id' => $user->id,
            'deal_status_id' => DealStatus::getByCode('awaiting_agent')->id,
            'advertisement_id' => $orderAdvertisement->id,
            'create_date' => date('Y-m-d'),
            ...request(['start_date', 'valid_until_date', 'address_id'])
        ]);

        return response([
            "id" => $deal->id
        ], 201);
    }

    public function close(int $dealId)
    {
        // Если сделки не существует, выбрасываем ошибку
        if(!$deal = Deal::find($dealId))
            throw new NotFoundException("Deal");

        // Получаем пользователя
        $user = auth()->user();

        // Если пользователь не имеет отношения к сделке и не является админом, то запрещаем закрытие
        if ($deal->user_id !== $user->id
            && $deal->employee_id !== $user->id
            && $user->role->code !== "admin")
            throw new ForbiddenForYouException();

        // Если сделка уже закрыта или завершена, то запрещаем изменение статуса
        if (array_search($deal->deal_status->code, ["closed", "completed"]) !== false)
            throw new ApiException(400, "The deal has already been closed");

        // Закрываем сделку
        $deal->setStatus("closed");
        $deal->save();

        // Ставим объявление архивным
        $advertisement = Advertisement::find($deal->advertisement_id);
        $advertisement->is_archive = true;
        $advertisement->save();

        return response(null,200);
    }

    public function edit(DealEditRequest $request, int $dealId)
    {
        // Если сделки не существует, выбрасываем ошибку
        if(!$deal = Deal::find($dealId))
            throw new NotFoundException("Deal");

        // Получаем обратившегося пользователя
        $user = auth()->user();

        // Если пользователь админ или ведёт сделку, то разрешаем редактировать
        if ($user->role->code === "admin"
            || $deal->employee_id === $user->id)
            $editData = request([
                "deal_status_id",
                "percent",
                "start_date",
                "valid_until_date",
                "address_id"
            ]);
        else
            throw new ForbiddenForYouException();

        // Если пользователь админ, то разрешаем менять (назначать) работника
        if ($user->role->code === "admin")
            $editData = [
                ...$editData,
                ...request(["employee_id"])
            ];

        // Обновляем сделку
        $deal->update($editData);

        return response(null, 200);
    }

    public function statuses()
    {
        return response(DealStatus::all(), 200);
    }
}
