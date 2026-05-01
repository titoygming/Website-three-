<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ── Repair Services ──────────────────────────────────────
        $repairServices = [
            [
                'name' => 'Screen Repair',
                'type' => 'repair',
                'price' => 2500,
                'description' => 'Professional screen replacement for smartphones and tablets. OEM quality LCD/OLED panels with 90-day warranty.',
            ],
            [
                'name' => 'Battery Replacement',
                'type' => 'repair',
                'price' => 1200,
                'description' => 'Restore your device battery health to 100%. Genuine cells with full capacity guarantee.',
            ],
            [
                'name' => 'Network Unlock via IMEI',
                'type' => 'repair',
                'price' => 800,
                'description' => 'Permanently unlock your device to use with any carrier worldwide. All brands supported.',
            ],
            [
                'name' => 'FRP Bypass',
                'type' => 'repair',
                'price' => 1500,
                'description' => 'Factory Reset Protection removal for Android devices. Supports Samsung, Huawei, Xiaomi & more.',
            ],
            [
                'name' => 'Software Flash & Recovery',
                'type' => 'repair',
                'price' => 1000,
                'description' => 'Complete firmware reinstallation and software recovery. Fix bootloops, bricks, and corrupted OS.',
            ],
            [
                'name' => 'Data Recovery',
                'type' => 'repair',
                'price' => 3500,
                'description' => 'Recover lost photos, contacts, messages and files from damaged or formatted devices.',
            ],
            [
                'name' => 'Water Damage Repair',
                'type' => 'repair',
                'price' => 2800,
                'description' => 'Full diagnostics and component-level repair for liquid damaged devices with board cleaning.',
            ],
            [
                'name' => 'Charging Port Repair',
                'type' => 'repair',
                'price' => 900,
                'description' => 'Replace faulty USB-C or Lightning charging ports. Includes flex cable and testing.',
            ],
        ];

        // ── Gift Cards ───────────────────────────────────────────
        $giftCards = [
            [
                'name' => 'Amazon Gift Card',
                'type' => 'giftcard',
                'price' => 1000,
                'description' => 'Shop millions of products on Amazon. Available in multiple denominations from MZN 1.000 to MZN 30.000.',
            ],
            [
                'name' => 'App Store & iTunes',
                'type' => 'giftcard',
                'price' => 1500,
                'description' => 'Purchase apps, games, music, movies and more from the Apple ecosystem. Global region activation.',
            ],
            [
                'name' => 'Google Play Credit',
                'type' => 'giftcard',
                'price' => 800,
                'description' => 'Buy apps, games, movies, books and more on Google Play. Instant digital delivery.',
            ],
            [
                'name' => 'Netflix Gift Card',
                'type' => 'giftcard',
                'price' => 3500,
                'description' => 'Enjoy unlimited streaming of movies and TV shows. Perfect gift for entertainment lovers.',
            ],
            [
                'name' => 'PlayStation Store',
                'type' => 'giftcard',
                'price' => 2500,
                'description' => 'Top up your PSN wallet for games, DLC, subscriptions and in-game purchases.',
            ],
            [
                'name' => 'Xbox Gift Card',
                'type' => 'giftcard',
                'price' => 2500,
                'description' => 'Add funds to your Microsoft account for Xbox games, Game Pass, and digital content.',
            ],
        ];

        foreach ([...$repairServices, ...$giftCards] as $service) {
            Service::query()->create($service);
        }
    }
}
