<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AdvertisementType;
use App\Models\AdvertisementTypeFilter;
use App\Models\Filter;
use App\Models\FilterValue;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    protected $classes = [
        "AdvertisementTypeFilter" => AdvertisementTypeFilter::class,
        "AdvertisementType" => AdvertisementType::class,
        "Filter" => Filter::class,
        "FilterValue" => FilterValue::class,
        "User" => User::class,
        "Role" => Role::class
    ];
    public function run(): void
    {
        $seederDataPath = env("SEEDER_DATA_FILE_PATH");
        if (!file_exists($seederDataPath)) {
            $this->command->error("Database seeder data not found...");
            return;
        }

        $this->command->info("Database seeder data is found. Run seeding file '$seederDataPath'...");

        $databaseSeederData = json_decode(file_get_contents($seederDataPath));

        foreach ($databaseSeederData as $rootTable => $rootData) {
            $this->recursiveRead($rootTable, $rootData);
        }
    }
    public function recursiveRead(string $rootTable, array|object $rootData): int | null
    {
        if (!is_object($rootData)) {
            foreach ($rootData as $childrenData) {
                $this->recursiveRead($rootTable, $childrenData);
            }
            return null;
        }

        $class = $this->classes[$rootTable];
        $fields_to_save = [];
        $field_name_to_mass = null;
        $mass_is_table = false;
        foreach ($rootData as $field => $value) {
            $field_length = strlen($field);
            if ($field[$field_length - 1] == 's') {
                $field = substr($field, 0, $field_length - 1);
                $field_name_to_mass = $field;
            }
            $slugs = preg_split('/(?<=[a-z])(?=[A-Z])/u', $field);
            if (count($slugs) > 1 || $this->isLower($field)) {
                $slugs = array_map("strtolower", $slugs);
                $slugsField_name = join("_", [...$slugs, "id"]);
                if ($field_name_to_mass == $field) {
                    $mass_is_table = $field;
                    $field_name_to_mass = $slugsField_name;
                }
                $fields_to_save[$slugsField_name] = $mass_is_table != $field ? $this->recursiveRead($field, $value) : $value;
                continue;
            }
            $fields_to_save[$field] = $value;
        }

        if ($field_name_to_mass != null) {
            foreach ($fields_to_save[$field_name_to_mass] as $value)
                $class::firstOrCreate([
                    ...$fields_to_save,
                    $field_name_to_mass => $mass_is_table ? $this->recursiveRead($mass_is_table, $value) : $value
                ]);
            return null;
        }

        return $class::firstOrCreate($fields_to_save)->id;
    }
    public function isLower($str)
    {
        $chr = mb_substr ($str, 0, 1, "UTF-8");
        return mb_strtolower($chr, "UTF-8") != $chr;
    }
}
