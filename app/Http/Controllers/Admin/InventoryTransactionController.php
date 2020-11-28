<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\InventoryTransaction;
use App\Models\Exist;
use App\Services\ProductService;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

use App\Services\MessagingService;
use Illuminate\Support\Facades\Artisan;

use App\Exports\InventoryTransactionExport;
use Maatwebsite\Excel\Facades\Excel;

class InventoryTransactionController extends Controller
{
    public function index(Request $request)
    {
        $export2excel = $request->export2excel;
        $query = InventoryTransaction::orderBy('created_at', 'DESC');
        $filters_request = $request->filters;

        if (isset($filters_request)) {
            $filter_validations = [
                'code' => ['required', 'min:3'],
                'cat' => ['required', Rule::in(['change', 'sell'])],
                'shamsi_c' => ['required', 'jdate:Y/m/d'],
                'shamsiless' => ['required', 'jdate:Y/m/d'],
                'shamsimore' => ['required', 'jdate:Y/m/d'],
            ];

            $filters = json_decode($filters_request, true);

            $validator = Validator::make($filters, $filter_validations);

            foreach ($validator->errors()->getMessages() as $name => $error) {
                unset($filters[$name]);
            }

            foreach ($filters as $columnname => $keyword) {
                switch ($columnname) {
                    case "code":
                        $query->where('product_code', 'LIKE', "%{$keyword}%");
                        break;
                    case "cat":
                        if ($keyword == 'change')
                            $query->where(function ($builder) {
                                $builder->where('info->type', 'change')
                                    ->orWhere('info->type', 'add')
                                    ->orWhere('info->type', 'remove');
                            });

                        elseif ($keyword == 'sell')
                            $query->where('info->type', 'sell');
                        break;
                    default:

                        break;
                }
            }

            if (isset($filters['shamsi_c'])) {
                $date = Verta::parse($filters['shamsi_c'])->DateTime();
                $query->whereDate('created_at', $date);
            } else {
                if (isset($filters['shamsiless'])) {
                    $date = Verta::parse($filters['shamsiless'])->DateTime();
                    $query->whereDate('created_at', '<=', $date);
                }

                if (isset($filters['shamsimore'])) {
                    $date = Verta::parse($filters['shamsimore'])->DateTime();
                    $query->whereDate('created_at', '>=', $date);
                }
            }
        }

        if ($export2excel) {
            $export = new InventoryTransactionExport($query->get());
            return Excel::download($export, 'inventory-transactions.xlsx');
        }

        $transactions = $query->paginate(15)->appends(['filters' => $filters_request]);//->get();

        if ($request->ajax())
            return response()->json($transactions, 200);
        else
            return view('admin.inventory_transaction.index', compact('transactions'));
    }
}
