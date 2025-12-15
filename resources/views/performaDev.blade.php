@include('nav.navDev')

<main class="ml-60 pt-20 bg-neutral-900">

<div class="p-6 space-y-8 min-h-screen">

    <h1 class="text-3xl font-semibold text-white">Performa Layanan</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-neutral-800 p-6 rounded-xl border border-neutral-700">
            <p class="text-neutral-400 text-sm">Total Jasa</p>
            <h2 class="text-3xl font-bold mt-2 text-white">{{ $stats['services'] }}</h2>
        </div>

        <div class="bg-neutral-800 p-6 rounded-xl border border-neutral-700">
            <p class="text-neutral-400 text-sm">Total Pesanan</p>
            <h2 class="text-3xl font-bold mt-2 text-red-400">{{ $stats['orders'] }}</h2>
        </div>

        <div class="bg-neutral-800 p-6 rounded-xl border border-neutral-700">
            <p class="text-neutral-400 text-sm">Pesanan Selesai</p>
            <h2 class="text-3xl font-bold mt-2 text-green-400">{{ $stats['completed'] }}</h2>
        </div>

        <div class="bg-neutral-800 p-6 rounded-xl border border-neutral-700">
            <p class="text-neutral-400 text-sm">Pesanan Pending</p>
            <h2 class="text-3xl font-bold mt-2 text-neutral-400">{{ $stats['pending'] }}</h2>
        </div>

    </div>

    <!-- Earnings & Rating -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="bg-gradient-to-r from-green-900/50 to-emerald-900/50 p-6 rounded-xl border border-green-700/50">
            <p class="text-neutral-300 text-sm">Total Pendapatan</p>
            <h2 class="text-3xl font-bold mt-2 text-green-400">Rp {{ number_format($totalEarnings, 0, ',', '.') }}</h2>
        </div>

        <div class="bg-gradient-to-r from-yellow-900/50 to-amber-900/50 p-6 rounded-xl border border-yellow-700/50">
            <p class="text-neutral-300 text-sm">Rating Rata-rata</p>
            <h2 class="text-3xl font-bold mt-2 text-yellow-400">
                ⭐ {{ number_format($averageRating, 1) }}/5.0
            </h2>
        </div>

        <div class="bg-gradient-to-r from-purple-900/50 to-pink-900/50 p-6 rounded-xl border border-purple-700/50">
            <p class="text-neutral-300 text-sm">Total Review</p>
            <h2 class="text-3xl font-bold mt-2 text-neutral-400">{{ $totalReviews }}</h2>
        </div>

    </div>

    <!-- Conversion Rates -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-neutral-800 p-6 rounded-xl border border-neutral-700">
            <p class="text-neutral-400 text-sm">Tingkat Penyelesaian</p>
            <h2 class="text-3xl font-bold mt-2 text-white">
                @if($stats['orders'] > 0)
                    {{ number_format(($stats['completed'] / $stats['orders']) * 100, 1) }}%
                @else
                    0%
                @endif
            </h2>
            <p class="text-neutral-500 text-xs mt-2">Pesanan selesai dari total pesanan</p>
        </div>

        <div class="bg-neutral-800 p-6 rounded-xl border border-neutral-700">
            <p class="text-neutral-400 text-sm">Pesanan per Jasa</p>
            <h2 class="text-3xl font-bold mt-2 text-white">
                @if($stats['services'] > 0)
                    {{ number_format($stats['orders'] / $stats['services'], 1) }}
                @else
                    0
                @endif
            </h2>
            <p class="text-neutral-500 text-xs mt-2">Rata-rata pesanan per layanan</p>
        </div>

    </div>

    <!-- Chart Pesanan Multi Dataset -->
    <div class="bg-neutral-800 p-6 rounded-xl border border-neutral-700">
        <h2 class="text-xl font-bold text-white mb-4">Grafik Pesanan (12 Bulan Terakhir)</h2>
        <canvas id="chartOrders" height="100"></canvas>
    </div>

    <!-- Chart Pendapatan -->
    <div class="bg-neutral-800 p-6 rounded-xl border border-neutral-700">
        <h2 class="text-xl font-bold text-white mb-4">Grafik Pendapatan (12 Bulan Terakhir)</h2>
        <canvas id="chartEarnings" height="100"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labels = @json($monthLabels);
    const ordersData = @json($ordersData);
    const completedData = @json($completedData);
    const earningsData = @json($earningsData);

    // Chart Pesanan - Multi Dataset
    new Chart(document.getElementById('chartOrders'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Total Pesanan',
                    data: ordersData,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.3
                },
                {
                    label: 'Pesanan Selesai',
                    data: completedData,
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.3
                }
            ],
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: { 
                legend: { 
                    labels: { color: 'white' },
                    position: 'top'
                }
            },
            scales: {
                x: { 
                    ticks: { color: 'white' }
                },
                y: { 
                    beginAtZero: true,
                    ticks: { color: 'white' }
                },
            }
        }
    });

    // Chart Pendapatan
    new Chart(document.getElementById('chartEarnings'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: earningsData,
                backgroundColor: 'rgba(34, 197, 94, 0.6)',
                borderColor: '#22c55e',
                borderWidth: 2,
                borderRadius: 8
            }],
        },
        options: {
            responsive: true,
            plugins: { 
                legend: { 
                    labels: { color: 'white' }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: { 
                    ticks: { color: 'white' }
                },
                y: { 
                    beginAtZero: true,
                    ticks: { 
                        color: 'white',
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
            }
        }
    });
</script>

</main>