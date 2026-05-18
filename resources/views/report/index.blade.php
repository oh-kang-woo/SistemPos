@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .content-header {
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }
    .content-header h2 {
        margin: 0 0 4px 0;
        color: #1e293b;
        font-size: 24px;
    }
    .content-header p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .btn-print {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #1e293b;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        white-space: nowrap;
        width: fit-content;
        transition: all 0.2s;
    }
    .btn-print:hover {
        background: #334155;
    }

    .summary-box {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        display: flex;
        gap: 40px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .summary-item .label { color: #64748b; font-size: 14px; margin-bottom: 8px;}
    .summary-item .value { font-size: 24px; font-weight: bold; color: #1e293b;}

    /* Style untuk Tab */
    .tab-container { margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; display: flex; gap: 20px; }
    .tab-btn { background: none; border: none; padding: 10px 4px; font-size: 15px; font-weight: 500; color: #64748b; cursor: pointer; border-bottom: 2px solid transparent; }
    .tab-btn.active { color: #3b82f6; border-bottom-color: #3b82f6; }

    .view-section { display: none; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; }
    .view-section.active { display: block; }

    /* Style Tabel */
    .classic-table { width: 100%; border-collapse: collapse; }
    .classic-table th, .classic-table td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #e2e8f0; }
    .classic-table th { background-color: #f8fafc; color: #475569; font-weight: 600; font-size: 14px; }
</style>

<div class="content-header">
    <div>
        <h2>Laporan Penjualan</h2>
        <p>Ringkasan performa penjualan 30 hari terakhir</p>
    </div>
    <a href="{{ route('report.print') }}" target="_blank" class="btn-print"><i class="fas fa-print"></i> Cetak Laporan</a>
</div>

<div class="summary-box">
    <div class="summary-item">
        <div class="label">Total Pendapatan (Kotor)</div>
        <div class="value" style="color: #1e293b;">Rp {{ number_format($totalSemuaPendapatan, 0, ',', '.') }}</div>
    </div>

    <div class="summary-item">
        <div class="label">Total Pendapatan Bersih</div>
        <div class="value" style="color: #10b981;">Rp {{ number_format($totalPendapatanBersih, 0, ',', '.') }}</div>
    </div>

    <div class="summary-item">
        <div class="label">Total Transaksi Sukses</div>
        <div class="value" style="color: #8b5cf6;">{{ $totalSemuaTransaksi }} Trx</div>
    </div>
</div>
<div class="tab-container">
    <button class="tab-btn active" onclick="switchView('grafik', this)"><i class="fas fa-chart-line"></i> Tampilan Grafik</button>
    <button class="tab-btn" onclick="switchView('tabel', this)"><i class="fas fa-table"></i> Tampilan Tabel</button>
</div>

<div id="view-grafik" class="view-section active" style="background: transparent; border: none; padding: 0;">
    <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
        <h3 style="font-size: 16px; margin: 0 0 20px 0; color: #1e293b; font-weight: 600;">Pendapatan Harian</h3>
        <div style="position: relative; height: 300px; width: 100%;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <div style="display: flex; gap: 24px;">
        <div style="flex: 1; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
            <h3 style="font-size: 16px; margin: 0 0 20px 0; color: #1e293b; font-weight: 600;">Metode Pembayaran</h3>
            <div style="position: relative; height: 250px; width: 100%; display: flex; justify-content: center;">
                <canvas id="metodeChart"></canvas>
            </div>
        </div>

        <div style="flex: 2; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
            <h3 style="font-size: 16px; margin: 0 0 20px 0; color: #1e293b; font-weight: 600;">Pendapatan vs Pengeluaran</h3>
            <div style="position: relative; height: 250px; width: 100%;">
                <canvas id="vsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div id="view-tabel" class="view-section">
    <table class="classic-table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah Transaksi</th>
                <th>Pendapatan Harian</th>
            </tr>
        </thead>
        <div id="view-tabel" class="view-section">
    <table class="classic-table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah Transaksi</th>
                <th>Pendapatan Harian</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reportData as $hari)
            <tr>
                <td>{{ \Carbon\Carbon::parse($hari->tanggal)->translatedFormat('d F Y') }}</td>
                <td>{{ $hari->jumlah_transaksi }} Transaksi</td>
                <td style="font-weight: 600;">Rp {{ number_format($hari->total_pendapatan, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center; padding: 20px;">Belum ada data penjualan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
    </table>
</div>

<script>
    function switchView(viewId, btnElement) {
        document.querySelectorAll('.view-section').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

        document.getElementById('view-' + viewId).style.display = 'block';
        btnElement.classList.add('active');
    }

    const labelTanggal = {!! json_encode($labelTanggal) !!};
    const dataPendapatan = {!! json_encode($dataPendapatan) !!};
    const dataPengeluaran = {!! json_encode($dataPengeluaran) !!};
    const labelMetode = {!! json_encode($labelMetode) !!};
    const dataMetode = {!! json_encode($dataMetode) !!};

    // --- TAMBAHAN: Hitung Pendapatan Bersih Harian otomatis di Javascript ---
    const dataPendapatanBersih = dataPendapatan.map((pendapatanKotor, index) => {
        return pendapatanKotor - dataPengeluaran[index];
    });

    // --- GRAFIK GARIS (SALES CHART) ---
    const ctxSales = document.getElementById('salesChart').getContext('2d');
    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: labelTanggal,
            datasets: [
                {
                    label: 'Pendapatan Bersih', // Garis Hijau (Bersih)
                    data: dataPendapatanBersih,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Pendapatan Kotor', // Garis Biru Gelap (Kotor)
                    data: dataPendapatan,
                    borderColor: '#1e293b',
                    backgroundColor: 'rgba(30, 41, 59, 0.05)',
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#1e293b',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true, // Diaktifkan agar terlihat mana garis kotor & bersih
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5] },
                    ticks: { callback: value => value.toLocaleString('id-ID') }
                },
                x: { grid: { display: false } }
            }
        }
    });

    // --- GRAFIK DONUT (METODE PEMBAYARAN) ---
    const ctxMetode = document.getElementById('metodeChart').getContext('2d');
    new Chart(ctxMetode, {
        type: 'doughnut',
        data: {
            labels: labelMetode,
            datasets: [{
                data: dataMetode,
                backgroundColor: ['#cbd5e1', '#64748b', '#334155'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: { boxWidth: 12, usePointStyle: true, padding: 20, font: { family: 'sans-serif' } }
                }
            }
        }
    });

    // --- GRAFIK BAR (PENDAPATAN VS PENGELUARAN) ---
    const ctxVs = document.getElementById('vsChart').getContext('2d');
    new Chart(ctxVs, {
        type: 'bar',
        data: {
            labels: labelTanggal,
            datasets: [
                {
                    label: 'Pendapatan',
                    data: dataPendapatan,
                    backgroundColor: '#94a3b8',
                    borderRadius: 4
                },
                {
                    label: 'Modal / Pengeluaran',
                    data: dataPengeluaran,
                    backgroundColor: '#475569',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true, // Diaktifkan juga untuk kejelasan
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5] },
                    ticks: { callback: value => value.toLocaleString('id-ID') }
                },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection
