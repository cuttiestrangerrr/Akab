@include('nav.navDev')

<main class="ml-60 pt-20 bg-neutral-900">

<div class="p-6 min-h-screen bg-neutral-900 text-white" x-data="chartController()">

    <h1 class="text-xl font-semibold mb-6">Dashboard Developer</h1>
    
    <!-- Top Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6 mb-10">
        <div class="bg-neutral-800 p-6 rounded-xl shadow border border-neutral-700">
            <h3 class="text-lg text-neutral-400">Pengajuan Masuk</h3>
            <p class="text-2xl font-bold mt-3 text-red-400">{{ $pengajuan }}</p>
        </div>
        <div class="bg-neutral-800 p-6 rounded-xl shadow border border-neutral-700">
            <h3 class="text-lg text-neutral-400">Disetujui</h3>
            <p class="text-2xl font-bold mt-3 text-green-400">{{ $disetujui }}</p>
        </div>
        <div class="bg-neutral-800 p-6 rounded-xl shadow border border-neutral-700">
            <h3 class="text-lg text-neutral-400">Ditolak</h3>
            <p class="text-2xl font-bold mt-3 text-red-400">{{ $ditolak }}</p>
        </div>
        <div class="bg-neutral-800 p-6 rounded-xl shadow border border-neutral-700">
            <h3 class="text-lg text-neutral-400">Pesanan Berjalan</h3>
            <p class="text-2xl font-bold mt-3 text-amber-400">{{ $berjalan }}</p>
        </div>
        <div class="bg-neutral-800 p-6 rounded-xl shadow border border-purple-700/50">
            <h3 class="text-lg text-neutral-400">Total Kunjungan</h3>
            <p class="text-2xl font-bold mt-3 text-neutral-400">{{ $totalKunjungan }}</p>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-neutral-800 p-6 rounded-xl shadow border border-neutral-700">
        <div class="flex flex-wrap items-center justify-between mb-4 gap-4">
            <h2 class="text-xl font-semibold">Grafik Performa (6 Bulan Terakhir)</h2>
            
            <!-- Dataset Toggles -->
            <div class="flex flex-wrap gap-3">
                <label class="flex items-center gap-2 cursor-pointer px-3 py-2 rounded-lg transition"
                       :class="datasets.pengajuan ? 'bg-red-600/30 border border-red-500' : 'bg-neutral-700 border border-neutral-600'">
                    <input type="checkbox" x-model="datasets.pengajuan" @change="updateChart()" 
                           :disabled="!datasets.pengajuan && selectedCount >= 3"
                           class="w-4 h-4 accent-blue-500">
                    <span class="text-sm">Pengajuan</span>
                </label>
                
                <label class="flex items-center gap-2 cursor-pointer px-3 py-2 rounded-lg transition"
                       :class="datasets.disetujui ? 'bg-green-600/30 border border-green-500' : 'bg-neutral-700 border border-neutral-600'">
                    <input type="checkbox" x-model="datasets.disetujui" @change="updateChart()"
                           :disabled="!datasets.disetujui && selectedCount >= 3"
                           class="w-4 h-4 accent-green-500">
                    <span class="text-sm">Disetujui</span>
                </label>
                
                <label class="flex items-center gap-2 cursor-pointer px-3 py-2 rounded-lg transition"
                       :class="datasets.ditolak ? 'bg-red-600/30 border border-red-500' : 'bg-neutral-700 border border-neutral-600'">
                    <input type="checkbox" x-model="datasets.ditolak" @change="updateChart()"
                           :disabled="!datasets.ditolak && selectedCount >= 3"
                           class="w-4 h-4 accent-red-500">
                    <span class="text-sm">Ditolak</span>
                </label>
                
                <label class="flex items-center gap-2 cursor-pointer px-3 py-2 rounded-lg transition"
                       :class="datasets.kunjungan ? 'bg-neutral-600/30 border border-neutral-500' : 'bg-neutral-700 border border-neutral-600'">
                    <input type="checkbox" x-model="datasets.kunjungan" @change="updateChart()"
                           :disabled="!datasets.kunjungan && selectedCount >= 3"
                           class="w-4 h-4 accent-purple-500">
                    <span class="text-sm">Kunjungan</span>
                </label>
                
                <label class="flex items-center gap-2 cursor-pointer px-3 py-2 rounded-lg transition"
                       :class="datasets.pendapatan ? 'bg-amber-600/30 border border-amber-500' : 'bg-neutral-700 border border-neutral-600'">
                    <input type="checkbox" x-model="datasets.pendapatan" @change="updateChart()"
                           :disabled="!datasets.pendapatan && selectedCount >= 3"
                           class="w-4 h-4 accent-amber-500">
                    <span class="text-sm">Pendapatan</span>
                </label>
            </div>
        </div>
        
        <p class="text-neutral-500 text-xs mb-4">Pilih maksimal 3 data untuk ditampilkan</p>
        
        <canvas id="chartPerforma" height="120"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const bulan = @json($monthLabels);
    const pengajuanData = @json($pengajuanData);
    const disetujuiData = @json($disetujuiData);
    const ditolakData = @json($ditolakData);
    const kunjunganData = @json($kunjunganData);
    const pendapatanData = @json($pendapatanData);

    let chartInstance = null;

    function chartController() {
        return {
            datasets: {
                pengajuan: true,
                disetujui: true,
                ditolak: false,
                kunjungan: false,
                pendapatan: true
            },
            
            get selectedCount() {
                return Object.values(this.datasets).filter(v => v).length;
            },
            
            init() {
                this.$nextTick(() => {
                    this.renderChart();
                });
            },
            
            updateChart() {
                if (chartInstance) {
                    chartInstance.destroy();
                }
                this.renderChart();
            },
            
            renderChart() {
                const ctx = document.getElementById('chartPerforma');
                const datasets = [];
                let hasPendapatan = false;
                
                if (this.datasets.pengajuan) {
                    datasets.push({
                        label: 'Pengajuan Masuk',
                        data: pengajuanData,
                        type: 'line',
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: false,
                        yAxisID: 'y'
                    });
                }
                
                if (this.datasets.disetujui) {
                    datasets.push({
                        label: 'Disetujui',
                        data: disetujuiData,
                        type: 'line',
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: false,
                        yAxisID: 'y'
                    });
                }
                
                if (this.datasets.ditolak) {
                    datasets.push({
                        label: 'Ditolak',
                        data: ditolakData,
                        type: 'line',
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: false,
                        yAxisID: 'y'
                    });
                }
                
                if (this.datasets.kunjungan) {
                    datasets.push({
                        label: 'Kunjungan',
                        data: kunjunganData,
                        type: 'line',
                        borderColor: '#a855f7',
                        backgroundColor: 'rgba(168, 85, 247, 0.1)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: false,
                        yAxisID: 'y'
                    });
                }
                
                if (this.datasets.pendapatan) {
                    hasPendapatan = true;
                    datasets.push({
                        label: 'Pendapatan (Rp)',
                        data: pendapatanData,
                        type: 'bar',
                        backgroundColor: 'rgba(251, 191, 36, 0.6)',
                        borderColor: '#f59e0b',
                        borderWidth: 2,
                        borderRadius: 8,
                        yAxisID: 'y1'
                    });
                }
                
                chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: bulan,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        scales: {
                            y: { 
                                type: 'linear',
                                display: true,
                                position: 'left',
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah',
                                    color: '#fff'
                                },
                                ticks: { color: '#fff' },
                                grid: { color: 'rgba(255,255,255,0.1)' }
                            },
                            y1: {
                                type: 'linear',
                                display: hasPendapatan,
                                position: 'right',
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Pendapatan (Rp)',
                                    color: '#fff'
                                },
                                ticks: { 
                                    color: '#fff',
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                },
                                grid: { drawOnChartArea: false }
                            },
                            x: {
                                ticks: { color: '#fff' },
                                grid: { color: 'rgba(255,255,255,0.1)' }
                            }
                        },
                        plugins: {
                            legend: { 
                                labels: { color: "#fff" },
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        if (context.dataset.label === 'Pendapatan (Rp)') {
                                            return context.dataset.label + ': Rp ' + context.raw.toLocaleString('id-ID');
                                        }
                                        return context.dataset.label + ': ' + context.raw;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
    }
</script>
</main>