<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Rating;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Static Users (For testing)
        User::create([
            'name' => 'Gigih Baskoro',
            'email' => 'gigih@akab.com',
            'password' => Hash::make('password'),
            'role' => 'developer',
            'specialization' => 'Full Stack Developer',
            'description' => 'Expert in Laravel, React, and System Architecture.',
            'average_rating' => 4.8,
            'profile_photo' => null,
        ]);

        User::create([
            'name' => 'Client User',
            'email' => 'client@akab.com',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);

        // 2. Random Key Developers & Services
        $devs = [
            ['name' => 'Andi Saputra', 'spec' => 'UI/UX Designer', 'desc' => 'Spesialis desain aplikasi mobile yang user-friendly.'],
            ['name' => 'Siti Aminah', 'spec' => 'Frontend Developer', 'desc' => 'Ahli membuat website interaktif dengan Vue.js.'],
            ['name' => 'Budi Santoso', 'spec' => 'Backend Engineer', 'desc' => 'Fokus pada keamanan dan performa server.'],
            ['name' => 'Citra Lestari', 'spec' => '3D Modeler', 'desc' => 'Membuat aset game 3D berkualitas tinggi.'],
            ['name' => 'Dewi Yuliani', 'spec' => 'Mobile Developer', 'desc' => 'Flutter & React Native expert.'],
        ];

        foreach ($devs as $d) {
            $user = User::create([
                'name' => $d['name'],
                'email' => strtolower(str_replace(' ', '', $d['name'])) . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'developer',
                'specialization' => $d['spec'],
                'description' => $d['desc'],
                'average_rating' => rand(35, 50) / 10,
            ]);

            // Create Services for this Dev
            $services = $this->getServicesForSpec($d['spec']);
            foreach ($services as $srv) {
                Service::create([
                    'id_developer' => $user->id,
                    'judul' => $srv['title'],
                    'deskripsi' => $srv['desc'],
                    'harga_mulai' => $srv['price'],
                    'kategori' => $srv['cat'],
                    'thumbnail' => null, // Placeholder logic in view
                ]);
            }
        }
    }

    private function getServicesForSpec($spec) {
        if (str_contains($spec, 'UI/UX')) {
            return [
                ['title' => 'Desain UI Aplikasi Mobile', 'desc' => 'Desain modern di Figma.', 'price' => 500000, 'cat' => 'Design'],
                ['title' => 'Wireframing & Prototyping', 'desc' => 'Alur UX lengkap.', 'price' => 300000, 'cat' => 'Design'],
            ];
        }
        if (str_contains($spec, 'Frontend')) {
            return [
                ['title' => 'Slicing Design ke React JS', 'desc' => 'Pixel perfect code.', 'price' => 1000000, 'cat' => 'Web'],
                ['title' => 'Landing Page Animasi', 'desc' => 'Interaktif dengan GSAP.', 'price' => 1500000, 'cat' => 'Web'],
            ];
        }
        if (str_contains($spec, 'Backend')) {
            return [
                ['title' => 'REST API dengan Laravel', 'desc' => 'API aman dan cepat.', 'price' => 2000000, 'cat' => 'Web'],
                ['title' => 'Optimasi Database MySQL', 'desc' => 'Tuning query lambat.', 'price' => 750000, 'cat' => 'Web'],
            ];
        }
        if (str_contains($spec, '3D')) {
            return [
                ['title' => 'Karakter Game low-poly', 'desc' => 'Siap untuk Unity.', 'price' => 400000, 'cat' => '3D'],
                ['title' => 'Render Produk Realistis', 'desc' => 'Untuk iklan.', 'price' => 800000, 'cat' => '3D'],
            ];
        }
        return [
            ['title' => 'Jasa Pembuatan Aplikasi', 'desc' => 'Custom request.', 'price' => 5000000, 'cat' => 'Mobile'],
        ];
    }
}
