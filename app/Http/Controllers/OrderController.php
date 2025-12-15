<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request, \App\Models\Service $service)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'selected_addons' => 'nullable|json',
            'custom_addon_price' => 'nullable|numeric',
        ]);

        $projectPrice = $service->harga_mulai;
        $description = $request->notes ?? 'Pemesanan jasa melalui marketplace.';

        // Process Addons
        $addonsDescription = "";
        if ($request->selected_addons) {
            $selectedAddons = json_decode($request->selected_addons, true);
            if (!empty($selectedAddons)) {
                $addonsDescription .= "\n\n-- Fitur Tambahan --";
                foreach ($selectedAddons as $addon) {
                    $projectPrice += $addon['price'];
                    $addonsDescription .= "\n• " . $addon['name'] . " (Rp " . number_format($addon['price'], 0, ',', '.') . ")";
                }
            }
        }

        // Process Custom Request
        if ($request->custom_addon_name && $request->custom_addon_price) {
            $projectPrice += $request->custom_addon_price;
            $addonsDescription .= "\n\n-- Permintaan Khusus --";
            $addonsDescription .= "\n• " . $request->custom_addon_name . " (Rp " . number_format($request->custom_addon_price, 0, ',', '.') . ")";
        }

        $fullDescription = $description . $addonsDescription;

        // Create Order record for tracking in user dashboard
        $order = \App\Models\Order::create([
            'user_id' => Auth::id(),
            'service_id' => $service->id_service,
            'status' => 'pending',
            'total_price' => $projectPrice,
            'note' => $fullDescription,
        ]);

        // Create a Project entry as the "Order" (for developer workflow)
        $project = \App\Models\Project::create([
            'id_pengguna' => Auth::id(),
            'id_developer' => $service->id_developer,
            'nama_proyek' => 'Pemesanan: ' . $service->judul,
            'deskripsi' => $fullDescription,
            'harga_estimasi' => $projectPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('home')->with('success', 'Pesanan Anda berhasil dibuat! Developer akan segera menghubungi Anda.');
    }

    public function indexDeveloper()
    {
        // Fetch projects where I am the developer and status is pending (Offers)
        $orders = \App\Models\Project::with(['client'])
                    ->where('id_developer', Auth::id())
                    ->where('status', 'pending')
                    ->latest()
                    ->get();

        return view('orderDev', compact('orders'));
    }
}
