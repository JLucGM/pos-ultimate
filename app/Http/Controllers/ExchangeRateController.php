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

        $rates = ExchangeRate::where('exchange_rates.business_id', $business_id)
            ->leftJoin('currencies as from_curr', 'exchange_rates.from_currency_id', '=', 'from_curr.id')
            ->leftJoin('currencies as to_curr', 'exchange_rates.to_currency_id', '=', 'to_curr.id')
            ->leftJoin('users', 'exchange_rates.created_by', '=', 'users.id')
            ->select([
                'exchange_rates.*',
                'from_curr.currency as from_currency_name',
                'from_curr.code as from_currency_code',
                'to_curr.currency as to_currency_name',
                'to_curr.code as to_currency_code',
                'users.username as creator_name'
            ]);

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
            ->editColumn('from_currency_name', function ($row) {
                return $row->from_currency_name . ' (' . $row->from_currency_code . ')';
            })
            ->editColumn('to_currency_name', function ($row) {
                return $row->to_currency_name . ' (' . $row->to_currency_code . ')';
            })
            ->editColumn('rate', function ($row) {
                return number_format($row->rate, 6);
            })
            ->editColumn('effective_date', function ($row) {
                return \Carbon\Carbon::parse($row->effective_date)->format('d/m/Y');
            })
            ->editColumn('creator_name', function ($row) {
                return $row->creator_name ?? '-';
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
        try {
            $business_id = $request->session()->get('user.business_id');
            
            if (!$business_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo obtener el ID del negocio'
                ], 400);
            }
            
            if (!$request->from_currency_id || !$request->to_currency_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Faltan parámetros requeridos: from_currency_id y to_currency_id'
                ], 400);
            }
            
            // Log para debug
            \Log::info('Getting exchange rate', [
                'business_id' => $business_id,
                'from' => $request->from_currency_id,
                'to' => $request->to_currency_id,
                'date' => $request->date
            ]);
            
            $rate = ExchangeRate::getRate(
                $business_id,
                $request->from_currency_id,
                $request->to_currency_id,
                $request->date
            );

            if ($rate === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró tasa de cambio para estas monedas en la fecha especificada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'rate' => $rate
            ]);
        } catch (\Exception $e) {
            \Log::error('Error getting exchange rate: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la tasa: ' . $e->getMessage()
            ], 500);
        }
    }
}
