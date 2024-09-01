<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->items as $item)
            Setting::query()->create($item);
    }

    private array $items = [
        ['key' => 'ref_base_address', 'value' => 'http://127.0.0.1:8002/api'],
        ['key' => 'kavenegar_key', 'value' => '3979482B5669653075494978307165794C56434D34356E6564695'],
        ['key' => 'rework_service_address', 'value' => 'http://localhost:3005/rework/v1/api/homework/admin/'],
    ];
}
