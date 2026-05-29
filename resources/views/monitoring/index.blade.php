<x-layouts.admin title="Monitoring Lingkungan" header="Monitoring">

    {{-- CDN dependencies --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

    <div x-data="monitoringApp()" x-init="init()">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-extrabold text-slate-800 tracking-tight">Monitoring Lingkungan Kandang</h1>
                <p class="text-xs text-slate-500 mt-1">Data suhu & kelembapan real-time dari sensor IoT</p>
            </div>

            {{-- Dropdown Pilih Kandang --}}
            <div class="w-full sm:w-64">
                <select x-model="selectedCage" @change="onCageChange()"
                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm">
                    <option value="">— Pilih Kandang —</option>
                    @foreach($cages as $cage)
                        <option value="{{ $cage->id }}">{{ $cage->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6" x-show="selectedCage" x-cloak>

            {{-- Suhu --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Suhu Terkini</p>
                        <p class="text-3xl font-extrabold text-slate-800 mt-1">
                            <span x-text="currentTemp !== null ? currentTemp + '°C' : '—'"></span>
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center">
                        <i data-lucide="thermometer" class="w-6 h-6 text-orange-500"></i>
                    </div>
                </div>
            </div>

            {{-- Kelembapan --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kelembapan Terkini</p>
                        <p class="text-3xl font-extrabold text-slate-800 mt-1">
                            <span x-text="currentHumidity !== null ? currentHumidity + '%' : '—'"></span>
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                        <i data-lucide="droplets" class="w-6 h-6 text-blue-500"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart --}}
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm" x-show="selectedCage" x-cloak>
            <div class="flex items-center gap-2 mb-4">
                <i data-lucide="activity" class="w-4 h-4 text-emerald-500"></i>
                <h3 class="font-bold text-sm text-slate-800">Grafik 24 Jam Terakhir</h3>
                <span class="ml-auto inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-green-50 border border-green-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-green-600 uppercase tracking-wider">Live</span>
                </span>
            </div>
            <div class="relative h-[350px]">
                <canvas id="environmentChart"></canvas>
            </div>
        </div>

        {{-- Empty State --}}
        <div x-show="!selectedCage" class="bg-white border border-slate-100 rounded-2xl p-12 shadow-sm text-center">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="radio-tower" class="w-8 h-8 text-emerald-400"></i>
            </div>
            <h3 class="font-bold text-slate-700 mb-1">Pilih Kandang</h3>
            <p class="text-xs text-slate-400">Pilih kandang dari dropdown di atas untuk melihat data monitoring.</p>
        </div>
    </div>

    <script>
        window._envChart = null;

        function monitoringApp() {
            return {
                selectedCage: '',
                currentTemp: null,
                currentHumidity: null,
                echoChannel: null,

                init() {
                    window.Pusher = Pusher;

                    const EchoClass = window.Echo;

                    window.Echo = new EchoClass({
                        broadcaster: 'pusher',
                        key: '{{ env("REVERB_APP_KEY") }}',
                        wsHost: '{{ env("REVERB_HOST", "localhost") }}',
                        wsPort: {{ env("REVERB_PORT", 8080) }},
                        forceTLS: false,
                        disableStats: true,
                        enabledTransports: ['ws'],
                        authEndpoint: '/broadcasting/auth',
                        auth: {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        }
                    });
                },

                onCageChange() {
                    if (this.echoChannel) {
                        window.Echo.leave(`cage.${this.echoChannel}`);
                        this.echoChannel = null;
                    }

                    if (!this.selectedCage) {
                        this.currentTemp = null;
                        this.currentHumidity = null;
                        if (window._envChart) {
                            window._envChart.destroy();
                            window._envChart = null;
                        }
                        return;
                    }

                    this.echoChannel = this.selectedCage;
                    this.fetchHistory();
                    this.subscribeToChannel();
                },

                async fetchHistory() {
                    const response = await fetch(`/monitoring/${this.selectedCage}/history`);
                    const data = await response.json();

                    const labels = data.map(d => this.formatTime(d.recorded_at));
                    const temps  = data.map(d => parseFloat(d.temperature));
                    const humids = data.map(d => parseFloat(d.humidity));

                    if (data.length > 0) {
                        const last = data[data.length - 1];
                        this.currentTemp     = parseFloat(last.temperature).toFixed(1);
                        this.currentHumidity = parseFloat(last.humidity).toFixed(1);
                    }

                    this.renderChart(labels, temps, humids);
                },

                subscribeToChannel() {
                    window.Echo.private(`cage.${this.selectedCage}`)
                        .listen('.environment.updated', (e) => {
                            this.currentTemp     = parseFloat(e.temperature).toFixed(1);
                            this.currentHumidity = parseFloat(e.humidity).toFixed(1);

                            const chart = window._envChart;
                            if (!chart) return;

                            const label = this.formatTime(e.recorded_at);
                            chart.data.labels.push(label);
                            chart.data.datasets[0].data.push(parseFloat(e.temperature));
                            chart.data.datasets[1].data.push(parseFloat(e.humidity));

                            if (chart.data.labels.length > 720) {
                                chart.data.labels.shift();
                                chart.data.datasets[0].data.shift();
                                chart.data.datasets[1].data.shift();
                            }

                            chart.update('none');
                        });
                },

                renderChart(labels, temps, humids) {
                    if (window._envChart) {
                        window._envChart.destroy();
                        window._envChart = null;
                    }

                    const ctx = document.getElementById('environmentChart').getContext('2d');

                    window._envChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Suhu (°C)',
                                    data: temps,
                                    borderColor: '#f97316',
                                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                                    borderWidth: 2,
                                    tension: 0.3,
                                    fill: true,
                                    pointRadius: 0,
                                    pointHitRadius: 10,
                                    yAxisID: 'y',
                                },
                                {
                                    label: 'Kelembapan (%)',
                                    data: humids,
                                    borderColor: '#3b82f6',
                                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                    borderWidth: 2,
                                    tension: 0.3,
                                    fill: true,
                                    pointRadius: 0,
                                    pointHitRadius: 10,
                                    yAxisID: 'y1',
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false,
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        padding: 20,
                                        font: { size: 11, weight: '600' }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                    titleFont: { size: 11 },
                                    bodyFont: { size: 12, weight: '600' },
                                    padding: 10,
                                    cornerRadius: 8,
                                }
                            },
                            scales: {
                                x: {
                                    ticks: {
                                        font: { size: 10 },
                                        maxTicksLimit: 12,
                                        maxRotation: 0,
                                    },
                                    grid: { display: false }
                                },
                                y: {
                                    type: 'linear',
                                    position: 'left',
                                    title: {
                                        display: true,
                                        text: 'Suhu (°C)',
                                        font: { size: 11, weight: '600' },
                                        color: '#f97316'
                                    },
                                    ticks: { font: { size: 10 } },
                                    grid: { color: 'rgba(0,0,0,0.04)' }
                                },
                                y1: {
                                    type: 'linear',
                                    position: 'right',
                                    title: {
                                        display: true,
                                        text: 'Kelembapan (%)',
                                        font: { size: 11, weight: '600' },
                                        color: '#3b82f6'
                                    },
                                    ticks: { font: { size: 10 } },
                                    grid: { drawOnChartArea: false }
                                }
                            }
                        }
                    });
                },

                formatTime(dateStr) {
                    const d = new Date(dateStr);
                    return d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                }
            };
        }
    </script>

</x-layouts.admin>
