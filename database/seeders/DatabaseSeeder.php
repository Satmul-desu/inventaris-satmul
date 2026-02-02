<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Item;
use App\Models\Location;
use App\Models\Notification;
use App\Models\Role;
use App\Models\Setting;
use App\Models\StockLog;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Roles
        $ownerRole = Role::create([
            'name' => 'owner',
            'description' => 'Administrator - Akses penuh ke sistem',
        ]);

        $staffRole = Role::create([
            'name' => 'staff',
            'description' => 'Penanggung Jawab - Akses terbatas',
        ]);

        // Create Admin User (Owner)
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@satmul.com',
            'password' => Hash::make('password123'),
            'role_id' => $ownerRole->id,
            'is_active' => true,
            'phone' => '081234567890',
            'address' => 'Kantor Satmul',
        ]);

        ActivityLog::log('Seeder: Admin user created', $admin->id);

        // Create Categories
        $categories = [
            ['name' => 'Elektronik', 'description' => 'Barang elektronik dan perangkat digital'],
            ['name' => 'Furniture', 'description' => 'Perabotan kantor dan rumah'],
            ['name' => 'ATK', 'description' => 'Alat Tulis Kantor'],
            ['name' => 'Kendaraan', 'description' => 'Kendaraan dinas'],
            ['name' => 'Lainnya', 'description' => 'Barang lainnya'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Units
        $units = [
            ['name' => 'pcs'],
            ['name' => 'box'],
            ['name' => 'pack'],
            ['name' => 'kg'],
            ['name' => 'liter'],
            ['name' => 'meter'],
            ['name' => 'unit'],
            ['name' => 'lembar'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }

        // Create Locations
        $locations = [
            ['name' => 'Gudang Utama', 'description' => 'Gudang penyimpanan utama'],
            ['name' => 'Ruang Kantor', 'description' => 'Ruang kerja staff'],
            ['name' => 'Ruang Rapat', 'description' => 'Ruang rapat'],
            ['name' => 'Ruang IT', 'description' => 'Ruang server dan peralatan IT'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }

        // Create Suppliers
        $suppliers = [
            ['name' => 'PT Maju Bersama', 'phone' => '021-5555555', 'address' => 'Jakarta'],
            ['name' => 'CV Sumber Jaya', 'phone' => '022-6666666', 'address' => 'Bandung'],
            ['name' => 'Toko Elektronik Sejahtera', 'phone' => '031-7777777', 'address' => 'Surabaya'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // Create Sample Items
        $items = [
            ['code' => 'BRG-001', 'name' => 'Laptop Lenovo ThinkPad', 'category_id' => 1, 'unit_id' => 7, 'stock' => 5, 'min_stock' => 2],
            ['code' => 'BRG-002', 'name' => 'Monitor LG 24 inch', 'category_id' => 1, 'unit_id' => 7, 'stock' => 8, 'min_stock' => 3],
            ['code' => 'BRG-003', 'name' => 'Keyboard USB', 'category_id' => 1, 'unit_id' => 1, 'stock' => 15, 'min_stock' => 5],
            ['code' => 'BRG-004', 'name' => 'Mouse Wireless', 'category_id' => 1, 'unit_id' => 1, 'stock' => 12, 'min_stock' => 5],
            ['code' => 'BRG-005', 'name' => 'Meja Kerja', 'category_id' => 2, 'unit_id' => 7, 'stock' => 4, 'min_stock' => 2],
            ['code' => 'BRG-006', 'name' => 'Kursi Kantor', 'category_id' => 2, 'unit_id' => 7, 'stock' => 6, 'min_stock' => 3],
            ['code' => 'BRG-007', 'name' => 'Lemari Arsip', 'category_id' => 2, 'unit_id' => 7, 'stock' => 2, 'min_stock' => 1],
            ['code' => 'BRG-008', 'name' => 'Ballpoint Hitam', 'category_id' => 3, 'unit_id' => 1, 'stock' => 50, 'min_stock' => 20],
            ['code' => 'BRG-009', 'name' => 'Kertas A4', 'category_id' => 3, 'unit_id' => 2, 'stock' => 10, 'min_stock' => 5],
            ['code' => 'BRG-010', 'name' => 'Stopmap', 'category_id' => 3, 'unit_id' => 1, 'stock' => 30, 'min_stock' => 10],
        ];

        foreach ($items as $item) {
            $newItem = Item::create($item);
            
            // Create initial stock log
            StockLog::create([
                'item_id' => $newItem->id,
                'action' => 'ADJUST',
                'qty' => $item['stock'],
                'previous_stock' => 0,
                'current_stock' => $item['stock'],
                'user_id' => $admin->id,
                'description' => 'Stok awal',
            ]);

            // Create low stock notification if needed
            if ($newItem->stock <= $newItem->min_stock && $newItem->stock > 0) {
                Notification::create([
                    'item_id' => $newItem->id,
                    'type' => 'low_stock',
                    'message' => "Stok {$newItem->name} ({$newItem->code}) menipis. Sisa stok: {$newItem->stock}",
                ]);
            }
        }

        // Create Settings
        $settings = [
            ['key' => 'app_name', 'value' => 'Inventaris Satmul'],
            ['key' => 'app_logo', 'value' => ''],
            ['key' => 'low_stock_threshold', 'value' => '10'],
            ['key' => 'email_notifications', 'value' => 'false'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin login: admin@satmul.com / password123');
    }
}

