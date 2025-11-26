@extends('admin_layout')

@section('admin_content')

@php
    // ===== Thống kê cơ bản =====
    $totalQty = $tongquan->sum('product_quantity');
    $inStock  = $tongquan->where('product_quantity', '>', 0)->count();
    $outStock = $tongquan->where('product_quantity', '<=', 0)->count();
    $totalProducts = $tongquan->count();

    // Gom theo danh mục
    $byCategory = collect($qty_category)->groupBy('category_id')->map(function($items){
        return [
            'category_name' => $items->first()->category_name ?? 'Không rõ',
            'count_product' => $items->count(),
            'sum_qty'       => $items->sum('product_quantity'),
        ];
    })->sortByDesc('sum_qty');

    // Top 5 tồn kho thấp
    $lowStock = $tongquan->sortBy('product_quantity')->take(5);
@endphp

<div class="row">
    <div class="col-sm-12">
        <h3 class="mb-3" style="color:teal;">📊 Bảng điều khiển quản trị</h3>
    </div>

    {{-- Cards tổng quan --}}
    <div class="col-md-3">
        <div class="panel b-a bg-white text-center p-3">
            <h2>{{ number_format($totalProducts) }}</h2>
            <p class="text-muted mb-0">Sản phẩm (SKU)</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel b-a bg-white text-center p-3">
            <h2>{{ number_format($totalQty) }}</h2>
            <p class="text-muted mb-0">Tổng tồn kho</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel b-a bg-white text-center p-3">
            <h2 class="text-success">{{ number_format($inStock) }}</h2>
            <p class="text-muted mb-0">Đang còn hàng</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel b-a bg-white text-center p-3">
            <h2 class="text-danger">{{ number_format($outStock) }}</h2>
            <p class="text-muted mb-0">Hết hàng</p>
        </div>
    </div>
</div>

<hr>

<div class="row">
    {{-- Bảng tồn kho theo danh mục --}}
    <div class="col-lg-7">
        <div class="panel panel-default">
            <div class="panel-heading">📦 Tồn kho theo danh mục</div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Danh mục</th>
                            <th class="text-end">Số sản phẩm</th>
                            <th class="text-end">Tổng tồn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($byCategory as $catId => $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row['category_name'] }}</td>
                                <td class="text-end">{{ number_format($row['count_product']) }}</td>
                                <td class="text-end">{{ number_format($row['sum_qty']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top tồn kho thấp --}}
    <div class="col-lg-5">
        <div class="panel panel-default">
            <div class="panel-heading">⚠️ Top 5 sản phẩm tồn kho thấp</div>
            <table class="table table-striped">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Tên SP</th>
                        <th class="text-end">Tồn</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStock as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->product_name ?? 'SP #'.$p->product_id }}</td>
                            <td class="text-end {{ $p->product_quantity <= 3 ? 'text-danger fw-bold' : '' }}">
                                {{ number_format($p->product_quantity) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="panel-footer text-muted"><small>* Đỏ = tồn &le; 3</small></div>
        </div>
    </div>
</div>

{{-- Biểu đồ trực quan --}}
<hr>
<div class="row">
    <div class="col-lg-7">
        <div class="panel panel-default">
            <div class="panel-heading">📈 Biểu đồ tồn kho theo danh mục</div>
            <div class="panel-body">
                <canvas id="chartCategory" height="250"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="panel panel-default">
            <div class="panel-heading">🥧 Tỷ lệ sản phẩm còn / hết hàng</div>
            <div class="panel-body">
                <canvas id="chartStock" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- Thêm script biểu đồ --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){

    // ===== Dữ liệu từ PHP sang JS =====
    const categories = @json($byCategory->pluck('category_name'));
    const qtys       = @json($byCategory->pluck('sum_qty'));
    const inStock    = {{ $inStock }};
    const outStock   = {{ $outStock }};

    // ===== Biểu đồ cột =====
    new Chart(document.getElementById('chartCategory'), {
        type: 'bar',
        data: {
            labels: categories,
            datasets: [{
                label: 'Tồn kho',
                data: qtys,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: false } }
        }
    });

    // ===== Biểu đồ tròn =====
    new Chart(document.getElementById('chartStock'), {
        type: 'doughnut',
        data: {
            labels: ['Còn hàng', 'Hết hàng'],
            datasets: [{
                data: [inStock, outStock],
                backgroundColor: ['#4CAF50', '#F44336']
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});
</script>
@endpush
