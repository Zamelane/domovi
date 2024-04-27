<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AdvertisementType;
use App\Models\AdvertisementTypeFilter;
use App\Models\Filter;
use App\Models\FilterValue;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    protected $notCommercialTypes = [
        "Квартира во вторичке",
        "Квартира в новостройке",
        "Комната",
        "Дом, дача",
        "Часть дома",
        "Таунхаус",
        "Участок",
        "Гараж"
    ];
    protected $commercialTypes = [
        "Офис",
        "Коммерческая земля"
    ];
    protected $adminLogin = "chernov-nm";
    protected $adminPassword = "chernov!";
    public function run(): void
    {
        $this->adminPassword = Str::random(10);
        $this->command->info('Creating roles...');
        // Роли
        $roleAdminId   = Role::firstOrCreate(['code' => 'admin'  ])->id;
        $roleManagerId = Role::firstOrCreate(['code' => 'manager'])->id;
        $roleOwnerId   = Role::firstOrCreate(['code' => 'owner'  ])->id;
        $roleUserId    = Role::firstOrCreate(['code' => 'user'   ])->id;

        $this->command->info("Creating users...");
        // Пользователи
        $admin = User::create([
            'first_name' => 'Чернов',
            'last_name' => 'Николай',
            'patronymic' => 'Михайлович',
            'phone' => 89994355644,
            'login' => $this->adminLogin,
            'password' => $this->adminPassword,
            'is_passed_moderation' => true,
            'is_banned' => false,
            'role_id' => $roleAdminId
        ]);
        $this->command->alert("\nUser admin created! Log in with the following credentials:"
            . "\nlogin: {$this->adminLogin}"
            . "\npassword: {$this->adminPassword}\n"
        );

        User::create([
            'first_name' => 'Демьянова',
            'last_name' => 'Кристина',
            'patronymic' => 'Максимовна',
            'phone' => 89964335121,
            'login' => 'demienova-km',
            'password' => 'demienova!',
            'is_passed_moderation' => true,
            'is_banned' => false,
            'role_id' => $roleManagerId
        ]);

        User::create([
            'first_name' => 'Серебрякова',
            'last_name' => 'Мария',
            'patronymic' => 'Андреевна',
            'phone' => 87359675432,
            'login' => 'serebrakova-ma',
            'password' => 'serebrakova!',
            'is_passed_moderation' => true,
            'is_banned' => false,
            'role_id' => $roleOwnerId
        ]);

        User::create([
            'first_name' => 'Фролова',
            'last_name' => 'София',
            'patronymic' => 'Демидовна',
            'phone' => 89432143567,
            'login' => 'frolova-cd',
            'password' => 'frolova!',
            'is_passed_moderation' => true,
            'is_banned' => false,
            'role_id' => $roleUserId
        ]);

        $this->command->info("Creating advertisement types...");
        // Типы объявлений
        foreach ($this->notCommercialTypes as $type)
            AdvertisementType::create([
                "name" => $type,
                "is_commercial" => false
            ]);
        foreach ($this->commercialTypes as $type)
            AdvertisementType::create([
                "name" => $type,
                "is_commercial" => true
            ]);

        $this->command->info("Creating filters...");
        // Фильтры
        $etageFilterId = Filter::create([
            "name" => "Этаж",
            "code" => "etage",
            "type" => "write_number"
        ])->id;

        $houseEtagesFilterId = Filter::create([
            "name" => "Этажей в доме",
            "code" => "allEtages",
            "type" => "write_number"
        ])->id;

        $buildingYearFilterId = Filter::create([
            "name" => "Год постройки дома",
            "code" => "houseBuildingYear",
            "type" => "write_number"
        ])->id;

        $heigthPotolFilterId = Filter::create([
            "name" => "Высота потолков (метры)",
            "code" => "heigthPotol",
            "type" => "write_number"
        ])->id;

        $propertyTypeFilterId = Filter::create([
            "name" => "Тип недвижимости",
            "code" => "propertyType",
            "type" => "select"
        ])->id;

        $typeHouseFilterId = Filter::create([
            "name" => "Тип дома",
            "code" => "typeHouse",
            "type" => "select"
        ])->id;

        $countBalconsFilterId = Filter::create([
            "name" => "Балконы/лоджии",
            "code" => "countBalcons",
            "type" => "summer_number"
        ])->id;

        $windowViewTypeFilterId = Filter::create([
            "name" => "Вид из окна",
            "code" => "windowView",
            "type" => "select"
        ])->id;

        $remontTypeFilterId = Filter::create([
            "name" => "Ремонт",
            "code" => "remontType",
            "type" => "select"
        ])->id;

        $availableLiftFilterId = Filter::create([
            "name" => "Есть лифт(ы)",
            "code" => "availableLift",
            "type" => "select"
        ])->id;

        $pandysFilterId = Filter::create([
            "name" => "Есть пандус",
            "code" => "pandys",
            "type" => "select"
        ])->id;

        $mysoroprovodFilterId = Filter::create([
            "name" => "Есть мусоропровод",
            "code" => "mysoroprovod",
            "type" => "select"
        ])->id;

        $parkovkaFilterId = Filter::create([
            "name" => "Тип парковки",
            "code" => "parkovka",
            "type" => "select"
        ])->id;

        $this->command->info("Creating filter values...");
        // Значения фильтра "Тип дома"
        $houseTypes = [
            "Кирпичный",
            "Монолитный",
            "Панельный",
            "Блочный",
            "Деревянный",
            "Сталинский",
            "Монолитно-кирпичный"
        ];
        foreach ($houseTypes as $type)
            FilterValue::create([
                "filter_id" => $typeHouseFilterId,
                "value" => $type
            ]);

        // Значения фильтра "Тип недвижимости"
        $propertyTypes = [
            "Квартира",
            "Апартаменты"
        ];
        foreach ($propertyTypes as $type)
            FilterValue::create([
                "filter_id" => $propertyTypeFilterId,
                "value" => $type
            ]);

        // Значения фильтра "Вид из окна"
        $windowTypes = [
            "На улицу",
            "Во двор"
        ];
        foreach ($windowTypes as $type)
            FilterValue::create([
                "filter_id" => $windowViewTypeFilterId,
                "value" => $type
            ]);

        // Значения фильтра "Ремонт"
        $remontTypes = [
            "Без ремонта",
            "Косметический",
            "Евро",
            "Дизайнерский"
        ];
        foreach ($remontTypes as $type)
            FilterValue::create([
                "filter_id" => $remontTypeFilterId,
                "value" => $type
            ]);

        // Значения фильтра "Лифт(ы)"
        $yesNo = [
            "Да",
            "Нет"
        ];
        foreach ($yesNo as $type)
            FilterValue::create([
                "filter_id" => $availableLiftFilterId,
                "value" => $type
            ]);

        // Значения фильтра "Есть пандус"
        foreach ($yesNo as $type)
            FilterValue::create([
                "filter_id" => $pandysFilterId,
                "value" => $type
            ]);

        // Значения фильтра "Есть мусоропровод"
        foreach ($yesNo as $type)
            FilterValue::create([
                "filter_id" => $mysoroprovodFilterId,
                "value" => $type
            ]);

        // Значения фильтра "Тип парковки"
        $remontTypes = [
            "Нету",
            "Наземная",
            "Многоуровневая",
            "Подземная",
            "На крыше"
        ];
        foreach ($remontTypes as $type)
            FilterValue::create([
                "filter_id" => $remontTypeFilterId,
                "value" => $type
            ]);

        $this->command->info("Creating associations filters from values...");
        // Ассоциация фильтров с типами объявлений
        $filters1 = [
            $etageFilterId,
            $houseEtagesFilterId,
            $buildingYearFilterId,
            $heigthPotolFilterId,
            $propertyTypeFilterId,
            $typeHouseFilterId,
            $countBalconsFilterId,
            $windowViewTypeFilterId,
            $remontTypeFilterId,
            $availableLiftFilterId,
            $pandysFilterId,
            $mysoroprovodFilterId,
            $parkovkaFilterId
        ];
        $associativies = [
            AdvertisementType::where("name", "Квартира во вторичке")->first()->id,
            AdvertisementType::where("name", "Квартира в новостройке")->first()->id
        ];
        foreach ($associativies as $advertisement_type_id)
            foreach ($filters1 as $filter_id)
                AdvertisementTypeFilter::create([
                    "filter_id" => $filter_id,
                    "advertisement_type_id" => $advertisement_type_id
                ]);
    }
}
