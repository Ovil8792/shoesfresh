<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StasticController extends Controller
{
    public function index(Request $request)
    {
        // --- Bộ lọc ---
        $orderFilter = $request->input('order_filter', 'all');
        $revenueFilter = $request->input('revenue_filter', 'all');
        $pendingFilter = $request->input('pending_filter', 'all');
        $cancelledFilter = $request->input('cancelled_filter', 'all');
        $posPendingFilter = $request->input('pos_pending_filter', 'all');
        $posPaidFilter = $request->input('pos_paid_filter', 'all');

        // --- Tổng doanh thu ---
        $revenueQuery = DB::table('orders')->where('status', 'completed');
        if ($revenueFilter == 'week') {
            $revenueQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($revenueFilter == 'month') {
            $revenueQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($revenueFilter == 'year') {
            $revenueQuery->whereYear('created_at', now()->year);
        }
        $revenue = $revenueQuery->sum('total_amount');

        // --- Tổng số đơn ---
        $ordersQuery = DB::table('orders');
        if ($orderFilter == 'week') {
            $ordersQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($orderFilter == 'month') {
            $ordersQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($orderFilter == 'year') {
            $ordersQuery->whereYear('created_at', now()->year);
        }
        $Orders = $ordersQuery->count();

        // --- Đơn đang xử lý ---
        $pendingQuery = DB::table('orders')->where('status', 'pending');
        if ($pendingFilter == 'week') {
            $pendingQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($pendingFilter == 'month') {
            $pendingQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($pendingFilter == 'year') {
            $pendingQuery->whereYear('created_at', now()->year);
        }
        $pendingOrders = $pendingQuery->count();

        // --- Đơn bị huỷ ---
        $cancelledQuery = DB::table('orders')->where('status', 'cancelled');
        if ($cancelledFilter == 'week') {
            $cancelledQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($cancelledFilter == 'month') {
            $cancelledQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($cancelledFilter == 'year') {
            $cancelledQuery->whereYear('created_at', now()->year);
        }
        $cancelledOrders = $cancelledQuery->count();

        // Số voucher đã dùng
        $voucherUsed = DB::table('orders')
            ->whereNotNull('voucher_id')
            ->count();
        // Số lượng người dùng có quyền khách hàng (role_id = 2) - chỉ đếm tài khoản chưa bị xóa
        $customers = DB::table('users')
            ->where('role_id', 2)
            ->whereNull('deleted_at')
            ->count();

        // Doanh thu từng tháng trong năm hiện tại
        $monthlyRevenue = DB::table('orders')
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        // Chuẩn bị dữ liệu cho biểu đồ
        $months = ['Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6','Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'];
        $revenueData = array_fill(0, 12, 0);
        foreach ($monthlyRevenue as $item) {
            $revenueData[$item->month - 1] = $item->revenue;
        }

        // Số sản phẩm đang bán
        $activeProducts = DB::table('products')->where('status', 1)->count();

        // Số sản phẩm hết hàng
        $outOfStockProducts = DB::table('product_variants')->where('stock', 0)->count();

        // Lấy danh sách 5 sản phẩm bán chạy nhất
        $bestSellerNames = $this->getTopProducts(now()->startOfMonth(), now()->endOfMonth(), 4, 'desc');
        $worstSellerNames = $this->getTopProducts(now()->startOfMonth(), now()->endOfMonth(), 4, 'asc');

        // Lấy danh sách đơn hàng chứa sản phẩm hết hàng
        $outOfStockVariantIds = DB::table('product_variants')->where('stock', 0)->pluck('id')->toArray();

        $outOfStockOrders = DB::table('order_items')
            ->whereIn('product_variant_id', $outOfStockVariantIds)
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->select('orders.id', 'orders.name', 'orders.email', 'orders.phone', 'orders.status', 'orders.created_at')
            ->distinct()
            ->get();

        // Số lượng hóa đơn chờ tại quầy
        $posPendingQuery = DB::table('pos_orders')->where('status', 'Đang chờ');
        if ($posPendingFilter == 'week') {
            $posPendingQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($posPendingFilter == 'month') {
            $posPendingQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($posPendingFilter == 'year') {
            $posPendingQuery->whereYear('created_at', now()->year);
        }
        $posPendingCount = $posPendingQuery->count();

        // Số lượng hóa đơn đã thanh toán tại quầy
        $posPaidQuery = DB::table('pos_orders')->where('status', 'Đã thanh toán');
        if ($posPaidFilter == 'week') {
            $posPaidQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($posPaidFilter == 'month') {
            $posPaidQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($posPaidFilter == 'year') {
            $posPaidQuery->whereYear('created_at', now()->year);
        }
        $posPaidCount = $posPaidQuery->count();

        // Biểu đồ doanh thu tại quầy theo tháng
        $monthlyPosRevenue = DB::table('pos_orders')
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->where('status', 'Đã thanh toán')
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        $posMonths = ['Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6','Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'];
        $posRevenueData = array_fill(0, 12, 0);
        foreach ($monthlyPosRevenue as $item) {
            $posRevenueData[$item->month - 1] = $item->revenue;
        }

        // Doanh thu trực tuyến
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();

        $onlineRevenue = DB::table('orders')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->sum('total_amount');

        $posRevenue = DB::table('pos_orders')
            ->where('status', 'Đã thanh toán')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->sum('total_amount');
        $totalRevenue = $onlineRevenue + $posRevenue;

        return view('admin.stastic.stastic', compact(
            'totalRevenue', 'onlineRevenue', 'posRevenue', 'revenueFilter',
            'revenue', 'Orders', 'voucherUsed','customers',
            'months', 'revenueData',
            'activeProducts', 'outOfStockProducts',
            'pendingOrders', 'cancelledOrders',
            'bestSellerNames','worstSellerNames',
            'outOfStockOrders',
            'posPendingCount', 'posPaidCount',
            'posMonths', 'posRevenueData',
            'posPendingFilter', 'posPaidFilter'
        ));
        
    }

    /**
     * Get revenue for a specific date range
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDateRangeRevenue(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Calculate online revenue
        $onlineRevenue = DB::table('orders')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->sum('total_amount');

        // Calculate POS revenue
        $posRevenue = DB::table('pos_orders')
            ->where('status', 'Đã thanh toán')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->sum('total_amount');

        $totalRevenue = $onlineRevenue + $posRevenue;

        return response()->json([
            'success' => true,
            'revenue' => $totalRevenue,
            'online_revenue' => $onlineRevenue,
            'pos_revenue' => $posRevenue
        ]);
    }

    /**
     * Get all statistics for a specific date range
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDateRangeStatistics(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date') . ' 23:59:59';

        // Calculate online revenue
        $onlineRevenue = DB::table('orders')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        // Calculate POS revenue
        $posRevenue = DB::table('pos_orders')
            ->where('status', 'Đã thanh toán')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $totalRevenue = $onlineRevenue + $posRevenue;

        // Total orders
        $totalOrders = DB::table('orders')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Pending orders
        $pendingOrders = DB::table('orders')
            ->where('status', 'pending')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Cancelled orders
        $cancelledOrders = DB::table('orders')
            ->where('status', 'cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Top products
        $bestSellerNames = $this->getTopProducts($startDate, $endDate, 4, 'desc');

        return response()->json([
            'success' => true,
            'revenue' => $totalRevenue,
            'online_revenue' => $onlineRevenue,
            'pos_revenue' => $posRevenue,
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'cancelled_orders' => $cancelledOrders,
            'best_sellers' => $bestSellerNames
        ]);
    }

    protected function getTopProducts($start, $end, $limit = 4, $direction = 'desc')
    {
        $orderDirection = $direction === 'asc' ? 'asc' : 'desc';

        $items = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->select('order_items.product_variant_id', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('order_items.product_variant_id')
            ->orderBy('total_sold', $orderDirection)
            ->limit($limit)
            ->get();

        $result = [];
        foreach ($items as $item) {
            $productVariant = DB::table('product_variants')->where('id', $item->product_variant_id)->first();
            if (!$productVariant) {
                continue;
            }
            $product = DB::table('products')->where('id', $productVariant->product_id)->first();
            if ($product) {
                $result[] = [
                    'name' => $product->name,
                    'total' => $item->total_sold,
                    'id' => $product->id,
                    'slug' => Str::slug($product->name),
                ];
            }
        }

        if (empty($result)) {
            $result[] = ['name' => 'Không có dữ liệu', 'total' => 0, 'id' => null];
        }

        return $result;
    }
}