<?php

namespace App\Http\Controllers;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Invoice;
use App\Models\InvoicePaymentDetails;
use App\Models\InvoiceProducts;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use DB;

class DashboardController extends Controller
{
    // admin/accountant dashboard
    public function index(Request $request) {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        if ($user->hasAccess('admin.dashboard')) {
            $allInvoices = Invoice::with('client')->where('is_deleted', 0)->orderBy("id", "desc")->take(6)->get();
            $paidInvoices = Invoice::where('payment_status', 1)->where('is_deleted', 0)->pluck('total_amount')->toArray();
            $pendingInvoices = Invoice::where('payment_status', 0)->where('is_deleted', 0)->pluck('total_amount')->toArray();
            $cancelInvoices = Invoice::where('payment_status', 3)->where('is_deleted', 0)->pluck('total_amount')->toArray();
            $totalAmountOfPaidInvoices = array_sum($paidInvoices);
            $totalAmountOfPendingInvoices = array_sum($pendingInvoices);
            $totalAmountOfCancelInvoices = array_sum($cancelInvoices);
            $allTransactions = InvoicePaymentDetails::where('status', 1)->orderBy("id", "desc")->take(6)->get();
            
            $latLong = [];
            $paidInvoiceCountries = Invoice::with('client')->where('payment_status', 1)->where('is_deleted', 0)->get();
            $file = public_path('assets/js/latlong.json');
            if(file_exists($file))
            {
                $data = file_get_contents($file);
                $country = json_decode($data, true);
            }
            foreach ($country['data'] as $key1 => $value1) {
                foreach ($paidInvoiceCountries as $key2 => $value2) {
                    if($value1['name'] == $value2['client']['country']) {
                        $latLong[$key2]['name'] = $value2['client']['country'];
                        $latLong[$key2]['coords'] = [$value1['lat'], $value1['long']];
                    }
                }
            }
            $latLong = array_reverse($latLong);
            $latLong = json_encode($latLong);

            // Country wise total earning and orders
            $invoiceWorldwideData = Invoice::select(DB::raw('sum(invoice.total_amount) as earning'), DB::raw('count(invoice.id) as orders'), DB::raw('users.country as country'))->join('users', 'users.id', '=', 'invoice.client_id')->where('is_deleted', 0)->where('payment_status', 1)->groupBy('users.country')->get()->toArray();

            $role = $user->roles[0]->slug;
            $client_role = Sentinel::findRoleBySlug('client');
            if ($role == 'admin' || $role == 'accountant') {
                $clients = $client_role->users()->with(['roles'])->orderByDesc('id')->take(6)->get();
            }

            return view('admin.dashboard',compact('user', 'role', 'allInvoices', 'totalAmountOfPaidInvoices', 'totalAmountOfPendingInvoices', 'totalAmountOfCancelInvoices','allTransactions','clients','latLong','invoiceWorldwideData'));
        } else {
            return view('error.403');
        }
    }

    // client dashboard
    public function clientDashboard(Request $request) {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        if ($user->hasAccess('invoice.view')) {
            $paidInvoices = Invoice::where('payment_status', 1)->where('is_deleted', 0)->pluck('total_amount')->toArray();
            $pendingInvoices = Invoice::where('payment_status', 0)->where('is_deleted', 0)->pluck('total_amount')->toArray();
            $cancelInvoices = Invoice::where('payment_status', 3)->where('is_deleted', 0)->pluck('total_amount')->toArray();
            $totalAmountOfPaidInvoices = array_sum($paidInvoices);
            $totalAmountOfPendingInvoices = array_sum($pendingInvoices);
            $totalAmountOfCancelInvoices = array_sum($cancelInvoices);

            return view('client.dashboard',compact('user', 'role', 'totalAmountOfPaidInvoices', 'totalAmountOfPendingInvoices', 'totalAmountOfCancelInvoices'));
        } else {
            return view('error.403');
        }
    }

    // ajax call for structure chart date filter
    public function structureDateFilter(Request $request) {
        $structureDate = $request->structureDate;
        $structureDate = explode(' to ', $structureDate);
        $fromDate = $structureDate[0];
        $toDate = $structureDate[1];

        $paidInvoices = Invoice::where('payment_status', 1)->where('is_deleted', 0)->whereBetween('date',[$fromDate,$toDate])->pluck('total_amount')->toArray();
        $pendingInvoices = Invoice::where('payment_status', 0)->where('is_deleted', 0)->whereBetween('date',[$fromDate,$toDate])->pluck('total_amount')->toArray();
        $cancelInvoices = Invoice::where('payment_status', 3)->where('is_deleted', 0)->whereBetween('date',[$fromDate,$toDate])->pluck('total_amount')->toArray();
        $totalAmountOfPaidInvoices = round(array_sum($paidInvoices));
        $totalAmountOfPendingInvoices = round(array_sum($pendingInvoices));
        $totalAmountOfCancelInvoices = round(array_sum($cancelInvoices));

        return ['totalAmountOfPaidInvoices' => $totalAmountOfPaidInvoices,
                'totalAmountOfPendingInvoices' => $totalAmountOfPendingInvoices,
                'totalAmountOfCancelInvoices' => $totalAmountOfCancelInvoices
            ];
    }

    // ajax call for payment-overview chart
    public function paymentOverviewChart(Request $request) {
        $monthArray = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $paidArray = [];
        $months = [];
        $returnPaidArray = [];
        $unpaidArray = [];
        $unpaidMonths = [];
        $returnUnpaidArray = [];

        // Array For Paid Amounts (month wise)
        $paidInvoices = Invoice::select(DB::raw('sum(total_amount) as total'), DB::raw('MONTHNAME(created_at) as month'))
                        ->whereYear('created_at', Carbon::now()->format($request->overviewDate))
                        ->where('is_deleted', 0)
                        ->where('payment_status', 1)
                        ->groupBy('month')
                        ->get()
                        ->toArray();
                    
        foreach ($paidInvoices as $key => $value) {
            array_push($months, $value['month']);
        }
        foreach($monthArray as $key => $month) {
            if (!in_array($month, $months)) {
                array_splice($paidInvoices, $key, 0, $month);
            }
        }
        foreach ($paidInvoices as $key => $value) {
            if(!isset($value['total'])) {
                $paidInvoices[$key] = [
                    'month' => $value,
                    'total' => 0,
                ];
            }
        }
        foreach ($paidInvoices as $key => $value) {
            $returnPaidArray[$key] = round($value['total']);
        }

        // Array For Unpaid Amounts (month wise)
        $unpaidInvoices = Invoice::select(DB::raw('sum(total_amount) as total'), DB::raw('MONTHNAME(created_at) as month'))
                        ->whereYear('created_at', Carbon::now()->format($request->overviewDate))
                        ->where('is_deleted', 0)
                        ->where('payment_status', 0)
                        ->groupBy('month')
                        ->get()
                        ->toArray();
        
        foreach ($unpaidInvoices as $key => $value) {
            array_push($unpaidMonths, $value['month']);
        }
        foreach($monthArray as $key => $month) {
            if (!in_array($month, $unpaidMonths)) {
                array_splice($unpaidInvoices, $key, 0, $month);
            }
        }
        foreach ($unpaidInvoices as $key => $value) {
            if(!isset($value['total'])) {
                $unpaidInvoices[$key] = [
                    'month' => $value,
                    'total' => 0,
                ];
            }
        }
        foreach ($unpaidInvoices as $key => $value) {
            $returnUnpaidArray[$key] = round($value['total']);
        }

        return ['paidArray'=>$returnPaidArray,'unpaidArray'=>$returnUnpaidArray];
    }

    // ajax call for payment-overview dropdown
    public function overviewDropdownFilter(Request $request) {
        $filter = $request->overviewDropdownFilter;
        $clientRole = Sentinel::findRoleBySlug('client');
        
        if($filter == 'today') {
            $clientAdded = $clientRole->users()->with('roles')->whereDate('users.created_at', Carbon::today())->count();
            $invoiceSent = Invoice::where('is_deleted', 0)->whereDate('created_at', Carbon::today())->count();
            $paidInvoice = Invoice::where('payment_status', 1)->where('is_deleted', 0)->whereDate('created_at', Carbon::today())->count();
            $unpaidInvoice = Invoice::where('payment_status', 0)->where('is_deleted', 0)->whereDate('created_at', Carbon::today())->count();
            $overviewText = "Today's Overview";
            
        } elseif($filter == 'last_week') {
            $clientAdded = $clientRole->users()->with('roles')->whereBetween('users.created_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
            $invoiceSent = Invoice::where('is_deleted', 0)->whereBetween('created_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
            $paidInvoice = Invoice::where('payment_status', 1)->where('is_deleted', 0)->whereBetween('created_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
            $unpaidInvoice = Invoice::where('payment_status', 0)->where('is_deleted', 0)->whereBetween('created_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
            $overviewText = "Last Week's Overview";

        } elseif($filter == 'last_month') {
            $clientAdded = $clientRole->users()->with('roles')->whereBetween('users.created_at',[Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString(), Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString()])->count();
            $invoiceSent = Invoice::where('is_deleted', 0)->whereBetween('created_at',[Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString(), Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString()])->count();
            $paidInvoice = Invoice::where('payment_status', 1)->where('is_deleted', 0)->whereBetween('created_at',[Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString(), Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString()])->count();
            $unpaidInvoice = Invoice::where('payment_status', 0)->where('is_deleted', 0)->whereBetween('created_at',[Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString(), Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString()])->count();
            $overviewText = "Last Month's Overview";

        } elseif($filter == 'current_year') {
            $clientAdded = $clientRole->users()->with('roles')->whereYear('users.created_at',date('Y'))->count();
            $invoiceSent = Invoice::where('is_deleted', 0)->whereYear('created_at',date('Y'))->count();
            $paidInvoice = Invoice::where('payment_status', 1)->where('is_deleted', 0)->whereYear('created_at',date('Y'))->count();
            $unpaidInvoice = Invoice::where('payment_status', 0)->where('is_deleted', 0)->whereYear('created_at',date('Y'))->count();
            $overviewText = "Current Year's Overview";
        } else {
            $clientAdded = $clientRole->users()->with('roles')->whereDate('users.created_at', Carbon::today())->count();
            $invoiceSent = Invoice::where('is_deleted', 0)->whereDate('created_at', Carbon::today())->count();
            $paidInvoice = Invoice::where('payment_status', 1)->where('is_deleted', 0)->whereDate('created_at', Carbon::today())->count();
            $unpaidInvoice = Invoice::where('payment_status', 0)->where('is_deleted', 0)->whereDate('created_at', Carbon::today())->count();
            $overviewText = "Today's Overview";
        }

        return ['clientAdded' => $clientAdded, 'invoiceSent' => $invoiceSent, 'paidInvoice' => $paidInvoice, 'unpaidInvoice' => $unpaidInvoice, 'overviewText' => $overviewText];
        
    }

    // ajax call for payment-activity chart
    public function paymentActivityChart(Request $request) {
        $monthArray = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $paidArray = [];
        $months = [];
        $dates = [];
        $returnPaidArray = [];
        $unpaidArray = [];
        $unpaidMonths = [];
        $unpaidDates = [];
        $returnUnpaidArray = [];
        $filter = $request->selectedValue;
        $where = '';
        $value = '';

        if($filter == 'current_year') {
            $paidInvoices = Invoice::select(DB::raw('sum(total_amount) as total'), DB::raw('MONTHNAME(created_at) as month'))
            ->whereYear('created_at', Carbon::now()->format(date('Y')))
            ->where('is_deleted', 0)
            ->where('payment_status', 1)
            ->groupBy('month')
            ->get()
            ->toArray();

            $unpaidInvoices = Invoice::select(DB::raw('sum(total_amount) as total'), DB::raw('MONTHNAME(created_at) as month'))
            ->whereYear('created_at', Carbon::now()->format(date('Y')))
            ->where('is_deleted', 0)
            ->where('payment_status', 0)
            ->groupBy('month')
            ->get()
            ->toArray();

            // Array For Paid Amounts (month wise) 
            foreach ($paidInvoices as $key => $value) {
                array_push($months, $value['month']);
            }
            foreach($monthArray as $key => $month) {
                if (!in_array($month, $months)) {
                    array_splice($paidInvoices, $key, 0, $month);
                }
            }
            foreach ($paidInvoices as $key => $value) {
                if(!isset($value['total'])) {
                    $paidInvoices[$key] = [
                        'month' => $value,
                        'total' => 0,
                    ];
                }
            }
            foreach ($paidInvoices as $key => $value) {
                $returnPaidArray[$key] = round($value['total']);
            }


            // Array For Unpaid Amounts (month wise)
            foreach ($unpaidInvoices as $key => $value) {
                array_push($unpaidMonths, $value['month']);
            }
            foreach($monthArray as $key => $month) {
                if (!in_array($month, $unpaidMonths)) {
                    array_splice($unpaidInvoices, $key, 0, $month);
                }
            }
            foreach ($unpaidInvoices as $key => $value) {
                if(!isset($value['total'])) {
                    $unpaidInvoices[$key] = [
                        'month' => $value,
                        'total' => 0,
                    ];
                }
            }
            foreach ($unpaidInvoices as $key => $value) {
                $returnUnpaidArray[$key] = round($value['total']);
            }
            
        } elseif($filter == 'six_months') {
            $lastSixMonthArray = [];
            for ($i = 1; $i <= 6; $i++) {
              array_push($lastSixMonthArray, date('F', strtotime("-$i month")));
            }
            $lastSixMonthArray = array_reverse($lastSixMonthArray);
            
            $paidInvoices = Invoice::select(DB::raw('sum(total_amount) as total'), DB::raw('MONTHNAME(created_at) as month'))
            ->whereBetween('invoice.created_at', [Carbon::now()->subMonth(6), Carbon::now()->subMonth()])
            ->where('is_deleted', 0)
            ->where('payment_status', 1)
            ->groupBy('month')
            ->get()
            ->toArray();

            $unpaidInvoices = Invoice::select(DB::raw('sum(total_amount) as total'), DB::raw('MONTHNAME(created_at) as month'))
            ->whereYear('created_at', [Carbon::now()->subMonth(6), Carbon::now()->subMonth()])
            ->where('is_deleted', 0)
            ->where('payment_status', 0)
            ->groupBy('month')
            ->get()
            ->toArray();

            // Array For Paid Amounts (month wise) 
            foreach ($paidInvoices as $key => $value) {
                array_push($months, $value['month']);
            }
            foreach($lastSixMonthArray as $key => $month) {
                if (!in_array($month, $months)) {
                    array_splice($paidInvoices, $key, 0, $month);
                }
            }
            foreach ($paidInvoices as $key => $value) {
                if(!isset($value['total'])) {
                    $paidInvoices[$key] = [
                        'month' => $value,
                        'total' => 0,
                    ];
                }
            }
            foreach ($paidInvoices as $key => $value) {
                $returnPaidArray[$key] = round($value['total']);
            }


            // Array For Unpaid Amounts (month wise)
            foreach ($unpaidInvoices as $key => $value) {
                array_push($unpaidMonths, $value['month']);
            }
            foreach($lastSixMonthArray as $key => $month) {
                if (!in_array($month, $unpaidMonths)) {
                    array_splice($unpaidInvoices, $key, 0, $month);
                }
            }
            foreach ($unpaidInvoices as $key => $value) {
                if(!isset($value['total'])) {
                    $unpaidInvoices[$key] = [
                        'month' => $value,
                        'total' => 0,
                    ];
                }
            }
            foreach ($unpaidInvoices as $key => $value) {
                $returnUnpaidArray[$key] = round($value['total']);
            }

        } elseif($filter == 'current_month') {

            $month = date('m');
            $year = date('Y');
            $start_date = "01-".$month."-".$year;
            $start_time = strtotime($start_date);
            $end_time = strtotime("+1 month", $start_time);
            for($i=$start_time; $i<$end_time; $i+=86400)
            {
                $currentMonthArray[] = date('d', $i);
            }

            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            $paidInvoices = Invoice::select(DB::raw('sum(total_amount) as total'), DB::raw('day(created_at) as day'))
            ->whereBetween('invoice.created_at', ["$startOfMonth", "$endOfMonth"])
            ->where('is_deleted', 0)
            ->where('payment_status', 1)
            ->groupBy('day')
            ->get()
            ->toArray();

            $unpaidInvoices = Invoice::select(DB::raw('sum(total_amount) as total'), DB::raw('day(created_at) as day'))
            ->whereBetween('invoice.created_at', ["$startOfMonth", "$endOfMonth"])
            ->where('is_deleted', 0)
            ->where('payment_status', 0)
            ->groupBy('day')
            ->get()
            ->toArray();

            // Array For Paid Amounts (month wise) 
            foreach ($paidInvoices as $key => $value) {
                array_push($dates, $value['day']);
            }
            foreach($currentMonthArray as $key => $date) {
                if (!in_array($date, $dates)) {
                    array_splice($paidInvoices, $key, 0, $date);
                }
            }
            foreach ($paidInvoices as $key => $value) {
                if(!isset($value['total'])) {
                    $paidInvoices[$key] = [
                        'date' => $value,
                        'total' => 0,
                    ];
                }
            }
            foreach ($paidInvoices as $key => $value) {
                $returnPaidArray[$key] = round($value['total']);
            }

            // Array For Unpaid Amounts (month wise)
            foreach ($unpaidInvoices as $key => $value) {
                array_push($unpaidDates, $value['day']);
            }
            foreach($currentMonthArray as $key => $date) {
                if (!in_array($date, $unpaidDates)) {
                    array_splice($unpaidInvoices, $key, 0, $date);
                }
            }
            foreach ($unpaidInvoices as $key => $value) {
                if(!isset($value['total'])) {
                    $unpaidInvoices[$key] = [
                        'date' => $value,
                        'total' => 0,
                    ];
                }
            }
            foreach ($unpaidInvoices as $key => $value) {
                $returnUnpaidArray[$key] = round($value['total']);
            }
            
        } else {

            $paidInvoices = Invoice::select(DB::raw('sum(total_amount) as total'), DB::raw('MONTHNAME(created_at) as month'))
            ->whereYear('created_at', Carbon::now()->format(date('Y')))
            ->where('is_deleted', 0)
            ->where('payment_status', 1)
            ->groupBy('month')
            ->get()
            ->toArray();

            $unpaidInvoices = Invoice::select(DB::raw('sum(total_amount) as total'), DB::raw('MONTHNAME(created_at) as month'))
            ->whereYear('created_at', Carbon::now()->format(date('Y')))
            ->where('is_deleted', 0)
            ->where('payment_status', 0)
            ->groupBy('month')
            ->get()
            ->toArray();

            // Array For Paid Amounts (month wise) 
            foreach ($paidInvoices as $key => $value) {
                array_push($months, $value['month']);
            }
            foreach($monthArray as $key => $month) {
                if (!in_array($month, $months)) {
                    array_splice($paidInvoices, $key, 0, $month);
                }
            }
            foreach ($paidInvoices as $key => $value) {
                if(!isset($value['total'])) {
                    $paidInvoices[$key] = [
                        'month' => $value,
                        'total' => 0,
                    ];
                }
            }
            foreach ($paidInvoices as $key => $value) {
                $returnPaidArray[$key] = round($value['total']);
            }

            // Array For Unpaid Amounts (month wise)
            foreach ($unpaidInvoices as $key => $value) {
                array_push($unpaidMonths, $value['month']);
            }
            foreach($monthArray as $key => $month) {
                if (!in_array($month, $unpaidMonths)) {
                    array_splice($unpaidInvoices, $key, 0, $month);
                }
            }
            foreach ($unpaidInvoices as $key => $value) {
                if(!isset($value['total'])) {
                    $unpaidInvoices[$key] = [
                        'month' => $value,
                        'total' => 0,
                    ];
                }
            }
            foreach ($unpaidInvoices as $key => $value) {
                $returnUnpaidArray[$key] = round($value['total']);
            }
        }

        // return paid and unpaid array
        return ['paidArray'=>$returnPaidArray,'unpaidArray'=>$returnUnpaidArray];
    }

    public  function change($local) {
        if ($local) {
            App::setLocale($local);
            session()->put('lang', $local);
            return redirect()->back()->with('local', $local);
        } else {
            return redirect()->back();
        }

    }



}
