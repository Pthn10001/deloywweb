@extends('admin_layout')

@section('admin_content')

@php
    // Tổng số lượng tồn kho tất cả sản phẩm
    $totalQty = $tongquan->sum('product_quantity');

    // Sản phẩm còn hàng / hết hàng
    $inStock  = $tongquan->where('product_quantity', '>', 0)->count();
    $outStock = $tongquan->where('product_quantity', '<=', 0)->count();

    // Tổng số sản phẩm (theo mã sp), không phải tổng tồn kho
    $totalProducts = $tongquan->count();

    // Gom theo danh mục (từ $qty_category là join product + category)
    $byCategory = collect($qty_category)->groupBy('category_id')->map(function($items){
        return [
            'category_name' => $items->first()->category_name ?? 'Không rõ',
            'count_product' => $items->count(),
            'sum_qty'       => $items->sum('product_quantity'),
        ];
    })->sortByDesc('sum_qty');

    // Top 5 tồn kho thấp để dễ refill
    $lowStock = $tongquan->sortBy('product_quantity')->take(5);
@endphp

<div class="row">
    {{-- Thẻ chào --}}
    <div class="col-sm-12">
        <h3 class="mb-3" style="color:teal;">Chào bạn đến với trang Admin</h3>
    </div>

    {{-- Cards tổng quan --}}
    <div class="col-sm-6 col-md-3">
        <div class="panel b-a bg-white">
            <div class="panel-body">
                <div class="h1 m0">{{ number_format($totalProducts) }}</div>
                <div class="text-muted">Sản phẩm (SKU)</div>
            </div>
            <div class="panel-footer bg-light lter">
                <span class="text-muted">Tổng số mã sản phẩm</span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="panel b-a bg-white">
            <div class="panel-body">
                <div class="h1 m0">{{ number_format($totalQty) }}</div>
                <div class="text-muted">Tổng tồn kho</div>
            </div>
            <div class="panel-footer bg-light lter">
                <span class="text-muted">Số lượng tồn tất cả sản phẩm</span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="panel b-a bg-white">
            <div class="panel-body">
                <div class="h1 m0">{{ number_format($inStock) }}</div>
                <div class="text-muted">Đang còn hàng</div>
            </div>
            <div class="panel-footer bg-light lter">
                <span class="text-muted">Sản phẩm có tồn &gt; 0</span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="panel b-a bg-white">
            <div class="panel-body">
                <div class="h1 m0">{{ number_format($outStock) }}</div>
                <div class="text-muted">Hết hàng</div>
            </div>
            <div class="panel-footer bg-light lter">
                <span class="text-muted">Cần nhập thêm</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Bảng tồn kho theo danh mục --}}
    <div class="col-lg-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                Tồn kho theo danh mục
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Danh mục</th>
                            <th class="text-right">Số sản phẩm</th>
                            <th class="text-right">Tổng tồn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($byCategory as $catId => $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row['category_name'] }}</td>
                                <td class="text-right">{{ number_format($row['count_product']) }}</td>
                                <td class="text-right">{{ number_format($row['sum_qty']) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Chưa có dữ liệu danh mục.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top 5 tồn kho thấp --}}
    <div class="col-lg-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                Top 5 sản phẩm tồn kho thấp
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên SP</th>
                            <th class="text-right">Tồn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStock as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->product_name ?? ('SP #'.$p->product_id) }}</td>
                                <td class="text-right {{ ($p->product_quantity ?? 0) <= 3 ? 'text-danger' : '' }}">
                                    {{ number_format($p->product_quantity ?? 0) }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3">Không có dữ liệu.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="panel-footer bg-light lter">
                <small class="text-muted">* Đánh dấu đỏ nếu tồn &le; 3</small>
            </div>
        </div>
    </div>
</div>

@endsection
