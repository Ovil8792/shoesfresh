@extends('admin.layout.master')

@section('main')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stats-dashboard {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
            padding: 30px;
            border-radius: 28px;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.15);
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }
        .stats-dashboard .cards {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 24px;
            margin-bottom: 24px;
        }
        .stats-dashboard .card {
            background: linear-gradient(120deg, #fff 80%, #e0e7ff 100%);
            border-radius: 18px;
            padding: 28px 20px;
            box-shadow: 0 6px 24px rgba(59, 130, 246, 0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }
        .stats-dashboard .card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 12px 32px rgba(59, 130, 246, 0.16);
        }
        .stats-dashboard .card h3 {
            font-size: 17px;
            color: #a03d07;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .stats-dashboard .card .value {
            font-size: 32px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 6px;
        }
        .stats-dashboard .card svg {
            width: 22px;
            height: 22px;
            vertical-align: middle;
        }
        .stats-dashboard .cards ul {
            font-size: 16px;
            margin: 0;
            padding-left: 18px;
        }
        .stats-dashboard .cards ul li {
            margin-bottom: 4px;
            color: #334155;
        }
        @media (max-width: 1200px) {
            .stats-dashboard .cards { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 700px) {
            .stats-dashboard .cards { grid-template-columns: 1fr; }
        }
        .stats-chart {
            background: #fff;
            border-radius: 22px;
            padding: 28px;
            box-shadow: 0 12px 30px rgba(160, 61, 7, 0.08);
            margin-top: 28px;
        }
        .stats-chart h3 {
            margin-bottom: 16px;
            color: #1f2a37;
            font-size: 20px;
            font-weight: 700;
        }
        .stats-chart canvas {
            width: 100%;
            max-height: 360px;
        }
    </style>

    <div class="stats-dashboard">
        <div class="cards">
            <div class="card" style="grid-column: span 2;">
                <h3>
                    <svg fill="#a03d07" viewBox="0 0 24 24"><path d="M12 3v18M3 12h18"/><circle cx="12" cy="12" r="10" stroke="#a03d07" stroke-width="2" fill="none"/></svg>
                    Tổng doanh thu tháng này
                </h3>
                <div class="value">{{ number_format($totalRevenue) }} ₫</div>
            </div>
            <div class="card">
                <h3><svg fill="#a03d07" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="4"/><path d="M8 8h8v8H8z"/></svg>Tổng số đơn</h3>
                <div class="value">{{ number_format($Orders) }}</div>
            </div>
            <div class="card">
                <h3><svg fill="#a03d07" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M6 20v-2a6 6 0 0 1 12 0v2"/></svg>Người dùng</h3>
                <div class="value">{{ number_format($customers) }}</div>
            </div>
            <div class="card">
                <h3><svg fill="#a03d07" viewBox="0 0 24 24"><path d="M5 12h14M12 5v14"/><circle cx="12" cy="12" r="10" stroke="#a03d07" stroke-width="2" fill="none"/></svg>Đang bán</h3>
                <div class="value">{{ number_format($activeProducts) }}</div>
            </div>
            <div class="card">
                <h3><svg fill="#dc3545" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#dc3545" stroke-width="2" fill="none"/><line x1="8" y1="8" x2="16" y2="16" stroke="#dc3545" stroke-width="2"/><line x1="16" y1="8" x2="8" y2="16" stroke="#dc3545" stroke-width="2"/></svg>Hết hàng</h3>
                <div class="value">{{ number_format($outOfStockProducts) }}</div>
            </div>
            <div class="card">
                <h3><svg fill="#f59e42" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#f59e42" stroke-width="2" fill="none"/><path d="M12 8v4l3 3" stroke="#f59e42" stroke-width="2" fill="none"/></svg>Đơn đang xử lý</h3>
                <div class="value">{{ number_format($pendingOrders) }}</div>
            </div>
            <div class="card">
                <h3><svg fill="#dc3545" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="4" stroke="#dc3545" stroke-width="2" fill="none"/><line x1="8" y1="8" x2="16" y2="16" stroke="#dc3545" stroke-width="2"/><line x1="16" y1="8" x2="8" y2="16" stroke="#dc3545" stroke-width="2"/></svg>Đơn bị huỷ</h3>
                <div class="value">{{ number_format($cancelledOrders) }}</div>
            </div>
            <div class="card" style="grid-column: span 2;">
                <h3><svg fill="#a03d07" viewBox="0 0 24 24"><path d="M12 2l3 7h7l-5.5 4.5L18 21l-6-4-6 4 2.5-7.5L2 9h7z"/></svg>Top 4 sản phẩm bán chạy tháng này</h3>
                <div class="value" style="font-size:16px;font-weight:500;color:#1f2937;">
                    <ul>
                        @foreach($bestSellerNames as $item)
                            <li>
                                @if(!empty($item['id']))
                                    <a href="{{ route('shop.product.show', ['name' => \Illuminate\Support\Str::slug($item['name']), 'id' => $item['id']]) }}" target="_blank" style="color:#d2601a;text-decoration:underline;">
                                        {{ $item['name'] }}
                                    </a>
                                    <span style="color:#9ca3af;">- {{ $item['total'] }} sản phẩm</span>
                                @else
                                    {{ $item['name'] }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="stats-chart">
            <h3>Biểu đồ doanh thu từng tháng</h3>
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    <script>
    window.renderStatsChart = function () {
        const chartCanvas = document.getElementById('monthlyChart');
        if (!chartCanvas || typeof Chart === 'undefined') {
            return;
        }
        const ctx = chartCanvas.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Doanh thu',
                    data: {!! json_encode($revenueData) !!},
                    borderColor: '#d2601a',
                    backgroundColor: 'rgba(210, 96, 26, 0.08)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#d2601a',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    };

    window.renderStatsChart();
    </script>
@endsection
