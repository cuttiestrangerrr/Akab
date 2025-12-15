<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\SearchLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create developers first
        $developers = $this->createDevelopers();
        
        // 100 dummy services
        $services = $this->get100Services();
        
        foreach ($services as $service) {
            $dev = $developers[array_rand($developers)];
            
            Service::create([
                'id_developer' => $dev->id,
                'judul' => $service['judul'],
                'deskripsi' => $service['deskripsi'],
                'harga_mulai' => $service['harga'],
                'kategori' => $service['kategori'],
                'thumbnail' => null,
                'views_count' => rand(0, 500),
            ]);
        }
        
        // Create search logs for testing recommendation
        $queries = ['Desain', 'Logo', 'Website', 'Mobile', 'Video', 'Editing', 'Pemrograman', 'Laravel', 'React', 'UI', 'Animasi', 'Ilustrasi', 'Thumbnail', 'Banner', 'Konsultasi'];
        foreach ($queries as $q) {
            for ($i = 0; $i < rand(5, 30); $i++) {
                SearchLog::create(['query' => $q, 'user_id' => null, 'created_at' => now()->subDays(rand(0, 30))]);
            }
        }
    }
    
    private function createDevelopers()
    {
        $devs = ['Ahmad Designer', 'Budi Programmer', 'Citra Animator', 'Dewi Konsultan', 'Eko Videografer', 'Fitri Developer', 'Gilang Editor', 'Hana Illustrator', 'Irfan Backend', 'Joko Frontend'];
        
        $developers = [];
        foreach ($devs as $name) {
            $dev = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $name)) . '@akab.dev'],
                ['name' => $name, 'password' => Hash::make('password'), 'role' => 'developer', 'specialization' => explode(' ', $name)[1], 'description' => "Profesional dengan pengalaman 5+ tahun.", 'average_rating' => rand(35, 50) / 10]
            );
            $developers[] = $dev;
        }
        return $developers;
    }
    
    private function get100Services()
    {
        return [
            // DESAIN (30)
            ['judul' => 'Desain Logo Profesional', 'deskripsi' => 'Logo modern dan memorable', 'harga' => 150000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Logo Minimalis', 'deskripsi' => 'Logo simpel dan elegan', 'harga' => 100000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Logo 3D', 'deskripsi' => 'Logo dengan efek 3D', 'harga' => 250000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Banner Sosmed', 'deskripsi' => 'Banner untuk Instagram/Facebook', 'harga' => 75000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Poster Event', 'deskripsi' => 'Poster eye-catching', 'harga' => 100000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Brosur', 'deskripsi' => 'Brosur informatif dan menarik', 'harga' => 120000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Flyer', 'deskripsi' => 'Flyer promosi efektif', 'harga' => 80000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Kartu Nama', 'deskripsi' => 'Kartu nama profesional', 'harga' => 50000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Packaging', 'deskripsi' => 'Kemasan produk yang menjual', 'harga' => 250000, 'kategori' => 'Desain'],
            ['judul' => 'Desain UI Mobile App', 'deskripsi' => 'Interface modern untuk app', 'harga' => 500000, 'kategori' => 'Desain'],
            ['judul' => 'Desain UI Website', 'deskripsi' => 'Tampilan website user-friendly', 'harga' => 400000, 'kategori' => 'Desain'],
            ['judul' => 'Ilustrasi Custom', 'deskripsi' => 'Ilustrasi digital sesuai keinginan', 'harga' => 200000, 'kategori' => 'Desain'],
            ['judul' => 'Ilustrasi Karakter', 'deskripsi' => 'Karakter untuk game/animasi', 'harga' => 300000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Infografis', 'deskripsi' => 'Infografis informatif', 'harga' => 150000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Feed Instagram', 'deskripsi' => 'Feed IG aesthetic', 'harga' => 300000, 'kategori' => 'Desain'],
            ['judul' => 'Mockup Produk', 'deskripsi' => 'Visualisasi produk realistis', 'harga' => 100000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Menu Restoran', 'deskripsi' => 'Menu makanan menggugah selera', 'harga' => 175000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Undangan Digital', 'deskripsi' => 'Undangan pernikahan digital', 'harga' => 125000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Kaos/Merchandise', 'deskripsi' => 'Desain untuk kaos/hoodie', 'harga' => 100000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Sticker Pack', 'deskripsi' => 'Sticker lucu untuk chat', 'harga' => 150000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Label Produk', 'deskripsi' => 'Label untuk produk UMKM', 'harga' => 80000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Banner Website', 'deskripsi' => 'Banner hero untuk website', 'harga' => 150000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Icon Pack', 'deskripsi' => 'Set ikon custom', 'harga' => 200000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Presentasi', 'deskripsi' => 'Slide PPT profesional', 'harga' => 175000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Sertifikat', 'deskripsi' => 'Sertifikat elegan', 'harga' => 75000, 'kategori' => 'Desain'],
            ['judul' => 'Desain ID Card', 'deskripsi' => 'Kartu identitas/member', 'harga' => 50000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Maskot', 'deskripsi' => 'Maskot untuk brand', 'harga' => 350000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Email Newsletter', 'deskripsi' => 'Template email marketing', 'harga' => 125000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Cover Buku', 'deskripsi' => 'Cover buku menarik', 'harga' => 200000, 'kategori' => 'Desain'],
            ['judul' => 'Desain Katalog Produk', 'deskripsi' => 'Katalog profesional', 'harga' => 300000, 'kategori' => 'Desain'],
            
            // EDITING VIDEO (25)
            ['judul' => 'Edit Video YouTube', 'deskripsi' => 'Editing profesional untuk YouTube', 'harga' => 200000, 'kategori' => 'Editing Video'],
            ['judul' => 'Edit Video TikTok', 'deskripsi' => 'Video viral untuk TikTok', 'harga' => 100000, 'kategori' => 'Editing Video'],
            ['judul' => 'Edit Video Wedding', 'deskripsi' => 'Dokumentasi pernikahan indah', 'harga' => 500000, 'kategori' => 'Editing Video'],
            ['judul' => 'Motion Graphics', 'deskripsi' => 'Animasi grafis untuk video', 'harga' => 350000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Company Profile', 'deskripsi' => 'Profil perusahaan profesional', 'harga' => 750000, 'kategori' => 'Editing Video'],
            ['judul' => 'Edit Podcast Video', 'deskripsi' => 'Editing untuk podcast video', 'harga' => 150000, 'kategori' => 'Editing Video'],
            ['judul' => 'Thumbnail YouTube', 'deskripsi' => 'Thumbnail menarik klik', 'harga' => 50000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Animasi 2D', 'deskripsi' => 'Animasi 2D explainer', 'harga' => 600000, 'kategori' => 'Editing Video'],
            ['judul' => 'Edit Reels Instagram', 'deskripsi' => 'Reels viral untuk IG', 'harga' => 100000, 'kategori' => 'Editing Video'],
            ['judul' => 'Color Grading', 'deskripsi' => 'Koreksi warna sinematik', 'harga' => 175000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Iklan Produk', 'deskripsi' => 'Iklan video untuk produk', 'harga' => 400000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Opening YouTube', 'deskripsi' => 'Intro channel YouTube', 'harga' => 150000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Outro YouTube', 'deskripsi' => 'Outro channel YouTube', 'harga' => 100000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Slideshow', 'deskripsi' => 'Slideshow foto dengan musik', 'harga' => 150000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Tutorial', 'deskripsi' => 'Edit video tutorial/edukatif', 'harga' => 200000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Lyric', 'deskripsi' => 'Video lirik lagu', 'harga' => 250000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Highlight Event', 'deskripsi' => 'Highlight acara/event', 'harga' => 300000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Testimony', 'deskripsi' => 'Video testimoni pelanggan', 'harga' => 175000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Behind The Scene', 'deskripsi' => 'BTS produksi', 'harga' => 200000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Unboxing', 'deskripsi' => 'Edit video unboxing produk', 'harga' => 125000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Review', 'deskripsi' => 'Edit video review produk', 'harga' => 175000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Cinematic', 'deskripsi' => 'Video sinematik berkualitas', 'harga' => 500000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Drone Editing', 'deskripsi' => 'Edit footage drone', 'harga' => 300000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Timelapse', 'deskripsi' => 'Edit video timelapse', 'harga' => 200000, 'kategori' => 'Editing Video'],
            ['judul' => 'Video Slow Motion', 'deskripsi' => 'Edit video slow motion', 'harga' => 150000, 'kategori' => 'Editing Video'],
            
            // PEMROGRAMAN (25)
            ['judul' => 'Website Company Profile', 'deskripsi' => 'Website profesional untuk bisnis', 'harga' => 1500000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Website E-commerce', 'deskripsi' => 'Toko online lengkap', 'harga' => 3000000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Landing Page', 'deskripsi' => 'Landing page konversi tinggi', 'harga' => 500000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Aplikasi Mobile Android', 'deskripsi' => 'App Android native', 'harga' => 5000000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Aplikasi Mobile iOS', 'deskripsi' => 'App iOS native', 'harga' => 6000000, 'kategori' => 'Pemrograman'],
            ['judul' => 'REST API Development', 'deskripsi' => 'Backend API yang scalable', 'harga' => 2000000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Website Laravel', 'deskripsi' => 'Website dengan Laravel', 'harga' => 2500000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Website React', 'deskripsi' => 'Web app dengan React', 'harga' => 2500000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Bot Telegram', 'deskripsi' => 'Bot otomatis untuk Telegram', 'harga' => 300000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Bot WhatsApp', 'deskripsi' => 'Bot customer service WA', 'harga' => 500000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Sistem Kasir/POS', 'deskripsi' => 'Point of Sale lengkap', 'harga' => 3500000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Sistem Inventory', 'deskripsi' => 'Manajemen stok barang', 'harga' => 2000000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Website WordPress', 'deskripsi' => 'Website dengan WordPress', 'harga' => 750000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Plugin WordPress', 'deskripsi' => 'Plugin custom WP', 'harga' => 400000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Slicing Figma to Code', 'deskripsi' => 'Konversi desain ke kode', 'harga' => 800000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Website Vue.js', 'deskripsi' => 'Web app dengan Vue.js', 'harga' => 2000000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Website Next.js', 'deskripsi' => 'Website dengan Next.js', 'harga' => 2500000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Aplikasi Flutter', 'deskripsi' => 'App cross-platform Flutter', 'harga' => 4000000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Sistem Reservasi', 'deskripsi' => 'Booking system online', 'harga' => 2500000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Sistem Absensi', 'deskripsi' => 'Aplikasi absensi karyawan', 'harga' => 1500000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Website Sekolah', 'deskripsi' => 'Website untuk sekolah', 'harga' => 2000000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Website Portfolio', 'deskripsi' => 'Portfolio website personal', 'harga' => 750000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Dashboard Admin', 'deskripsi' => 'Admin panel untuk web app', 'harga' => 1500000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Integrasi Payment Gateway', 'deskripsi' => 'Pasang pembayaran online', 'harga' => 500000, 'kategori' => 'Pemrograman'],
            ['judul' => 'Website Blog', 'deskripsi' => 'Blog dengan CMS', 'harga' => 1000000, 'kategori' => 'Pemrograman'],
            
            // KONSULTASI (10)
            ['judul' => 'Konsultasi Bisnis Online', 'deskripsi' => 'Strategi bisnis digital', 'harga' => 200000, 'kategori' => 'Konsultasi'],
            ['judul' => 'Konsultasi IT', 'deskripsi' => 'Solusi teknologi untuk bisnis', 'harga' => 250000, 'kategori' => 'Konsultasi'],
            ['judul' => 'Konsultasi SEO', 'deskripsi' => 'Optimasi mesin pencari', 'harga' => 300000, 'kategori' => 'Konsultasi'],
            ['judul' => 'Konsultasi Digital Marketing', 'deskripsi' => 'Strategi pemasaran digital', 'harga' => 250000, 'kategori' => 'Konsultasi'],
            ['judul' => 'Konsultasi UI/UX', 'deskripsi' => 'Review dan saran desain', 'harga' => 200000, 'kategori' => 'Konsultasi'],
            ['judul' => 'Konsultasi Startup', 'deskripsi' => 'Mentoring untuk startup', 'harga' => 350000, 'kategori' => 'Konsultasi'],
            ['judul' => 'Konsultasi Social Media', 'deskripsi' => 'Strategi sosial media', 'harga' => 200000, 'kategori' => 'Konsultasi'],
            ['judul' => 'Konsultasi E-commerce', 'deskripsi' => 'Optimasi toko online', 'harga' => 300000, 'kategori' => 'Konsultasi'],
            ['judul' => 'Konsultasi Branding', 'deskripsi' => 'Strategi brand awareness', 'harga' => 400000, 'kategori' => 'Konsultasi'],
            ['judul' => 'Konsultasi Content', 'deskripsi' => 'Strategi konten marketing', 'harga' => 250000, 'kategori' => 'Konsultasi'],
            
            // LAYANAN LAIN (10)
            ['judul' => 'Penulisan Artikel', 'deskripsi' => 'Artikel SEO-friendly', 'harga' => 50000, 'kategori' => 'Layanan Lain'],
            ['judul' => 'Virtual Assistant', 'deskripsi' => 'Asisten admin virtual', 'harga' => 150000, 'kategori' => 'Layanan Lain'],
            ['judul' => 'Data Entry', 'deskripsi' => 'Input data akurat', 'harga' => 100000, 'kategori' => 'Layanan Lain'],
            ['judul' => 'Translate ID-EN', 'deskripsi' => 'Penerjemahan profesional', 'harga' => 75000, 'kategori' => 'Layanan Lain'],
            ['judul' => 'Voiceover', 'deskripsi' => 'Suara profesional untuk video', 'harga' => 150000, 'kategori' => 'Layanan Lain'],
            ['judul' => 'Transcription', 'deskripsi' => 'Transkripsi audio/video', 'harga' => 100000, 'kategori' => 'Layanan Lain'],
            ['judul' => 'Copywriting', 'deskripsi' => 'Teks marketing yang menjual', 'harga' => 125000, 'kategori' => 'Layanan Lain'],
            ['judul' => 'Photo Editing', 'deskripsi' => 'Edit foto profesional', 'harga' => 75000, 'kategori' => 'Layanan Lain'],
            ['judul' => 'Music Production', 'deskripsi' => 'Produksi musik/jingle', 'harga' => 500000, 'kategori' => 'Layanan Lain'],
            ['judul' => 'Podcast Editing', 'deskripsi' => 'Edit audio podcast', 'harga' => 100000, 'kategori' => 'Layanan Lain'],
        ];
    }
}
