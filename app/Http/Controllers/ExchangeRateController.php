<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExchangeRateController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_exchange_rate')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $currencies = Currency::pluck('currency', 'id');

        return view('exchange_rates.index', compact('currencies'));
    }

    public function create()
    {
        if (!auth()->user()->can('create_exchange_rate')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $currencies = Currency::pluck('currency', 'id');

        return view('exchange_rates.create', compact('currencies'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create_exchange_rate')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'from_currency_id' => 'required|exists:currencies,id',
            'to_currency_id' => 'required|exists:currencies,id|different:from_currency_id',
            'rate' => 'required|numeric|min:0',
            'effective_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $business_id = $request->session()->get('user.business_id');

        ExchangeRate::create([
            'business_id' => $business_id,
            'from_currency_id' => $request->from_currency_id,
            'to_currency_id' => $request->to_currency_id,
            'rate' => $request->rate,
            'effective_date' => $request->effective_date,
            'created_by' => auth()->id(),
            'notes' => $request->notes
        ]);

        $output = [
            'success' => true,
            'msg' => __('exchange_rate.added_success')
        ];

        return redirect()->route('exchange-rates.index')->with('status', $output);
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit_exchange_rate')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $rate = ExchangeRate::where('business_id', $business_id)->findOrFail($id);
        $currencies = Currency::pluck('currency', 'id');

        return view('exchange_rates.edit', compact('rate', 'currencies'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('edit_exchange_rate')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'from_currency_id' => 'required|exists:currencies,id',
            'to_currency_id' => 'required|exists:currencies,id|different:from_currency_id',
            'rate' => 'required|numeric|min:0',
            'effective_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $business_id = $request->session()->get('user.business_id');
        $rate = ExchangeRate::where('business_id', $business_id)->findOrFail($id);

        $rate->update([
            'from_currency_id' => $request->from_currency_id,
            'to_currency_id' => $request->to_currency_id,
            'rate' => $request->rate,
            'effective_date' => $request->effective_date,
            'notes' => $request->notes
        ]);

        $output = [
            'success' => true,
            'msg' => __('exchange_rate.updated_success')
        ];

        return redirect()->route('exchange-rates.index')->with('status', $output);
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete_exchange_rate')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $rate = ExchangeRate::where('business_id', $business_id)->findOrFail($id);
        $rate->delete();

        $output = [
            'success' => true,
            'msg' => __('exchange_rate.deleted_success')
        ];

        return redirect()->route('exchange-rates.index')->with('status', $output);
    }

    public function getData()
    {
        if (!auth()->user()->can('view_exchange_rate')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $rates = ExchangeRate::where('business_id', $business_id)
            ->with(['fromCurrency', 'toCurrency', 'creator'])
            ->select('exchange_rates.*');

        return DataTables::of($rates)
            ->addColumn('action', function ($row) {
                $html = '<div class="btn-group">';
                $html .= '<button type="button" class="btn btn-info btn-xs btn-modal" data-container=".view_modal" data-href="' . action([\App\Http\Controllers\ExchangeRateController::class, 'show'], [$row->id]) . '"><i class="fa fa-eye"></i> ' . __('messages.view') . '</button>';
                
                if (auth()->user()->can('edit_exchange_rate')) {
                    $html .= '<a href="' . action([\App\Http\Controllers\ExchangeRateController::class, 'edit'], [$row->id]) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> ' . __('messages.edit') . '</a>';
                }
                
                if (auth()->user()->can('delete_exchange_rate')) {
                    $html .= '<button data-href="' . action([\App\Http\Controllers\ExchangeRateController::class, 'destroy'], [$row->id]) . '" class="btn btn-xs btn-danger delete_button"><i class="glyphicon glyphicon-trash"></i> ' . __('messages.delete') . '</button>';
                }
                
                $html .= '</div>';
                return $html;
            })
            ->editColumn('from_currency', function ($row) {
                return $row->fromCurrency->currency . ' (' . $row->fromCurrency->code . ')';
            })
            ->editColumn('to_currency', function ($row) {
                return $row->toCurrency->currency . ' (' . $row->toCurrency->code . ')';
            })
            ->editColumn('rate', function ($row) {
                return number_format($row->rate, 6);
            })
            ->editColumn('effective_date', function ($row) {
                return $row->effective_date->format('d/m/Y');
            })
            ->editColumn('created_by', function ($row) {
                return $row->creator ? $row->creator->username : '-';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show($id)
    {
        if (!auth()->user()->can('view_exchange_rate')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $rate = ExchangeRate::where('business_id', $business_id)
            ->with(['fromCurrency', 'toCurrency', 'creator'])
            ->findOrFail($id);

        return view('exchange_rates.show', compact('rate'));
    }

    /**
     * API para obtener la tasa actual
     */
    public function getCurrentRate(Request $request)
    {
        $business_id = $request->session()->get('user.business_id');
        
        $rate = ExchangeRate::getRate(
            $business_id,
            $request->from_currency_id,
            $request->to_currency_id,
            $request->date
        );

        return response()->json([
            'success' => true,
            'rate' => $rate
        ]);
    }
}
