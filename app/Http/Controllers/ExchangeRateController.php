<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExchangeRateController extends Controller
{
    protected $commonUtil;

    public function __construct(\App\Utils\Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }

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

    protected function parseDate($dateStr)
    {
        if (empty($dateStr)) {
            return date('Y-m-d');
        }

        try {
            $parsed = $this->commonUtil->uf_date($dateStr);
            if (!empty($parsed)) {
                return $parsed;
            }
        } catch (\Throwable $e) {}

        foreach (['d/m/Y', 'Y-m-d', 'd-m-Y', 'm/d/Y'] as $fmt) {
            try {
                return \Carbon\Carbon::createFromFormat($fmt, $dateStr)->format('Y-m-d');
            } catch (\Throwable $e) {}
        }

        try {
            return \Carbon\Carbon::parse($dateStr)->format('Y-m-d');
        } catch (\Throwable $e) {}

        return date('Y-m-d');
    }

    protected function parseRate($rateStr)
    {
        if (empty($rateStr)) {
            return 0;
        }
        if (is_numeric($rateStr)) {
            return (float) $rateStr;
        }
        $cleaned = str_replace(' ', '', (string) $rateStr);
        // Handle format like 1.234,56 or 1234,56
        if (strpos($cleaned, ',') !== false && strpos($cleaned, '.') !== false) {
            $cleaned = str_replace('.', '', $cleaned);
            $cleaned = str_replace(',', '.', $cleaned);
        } else if (strpos($cleaned, ',') !== false) {
            $cleaned = str_replace(',', '.', $cleaned);
        }
        return (float) $cleaned;
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create_exchange_rate')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id') ?: 1;

        $effective_date = $this->parseDate($request->input('effective_date'));
        $rate = $this->parseRate($request->input('rate'));

        if ($rate <= 0) {
            return redirect()->back()->withInput()->with('status', [
                'success' => false,
                'msg' => 'La tasa de cambio debe ser un número mayor a 0.'
            ]);
        }

        if (!$request->input('from_currency_id') || !$request->input('to_currency_id')) {
            return redirect()->back()->withInput()->with('status', [
                'success' => false,
                'msg' => 'Debe seleccionar la moneda de origen y la moneda de destino.'
            ]);
        }

        if ($request->input('from_currency_id') == $request->input('to_currency_id')) {
            return redirect()->back()->withInput()->with('status', [
                'success' => false,
                'msg' => 'La moneda de origen y destino no pueden ser iguales.'
            ]);
        }

        ExchangeRate::updateOrCreate(
            [
                'business_id' => $business_id,
                'from_currency_id' => $request->input('from_currency_id'),
                'to_currency_id' => $request->input('to_currency_id'),
                'effective_date' => $effective_date,
            ],
            [
                'rate' => $rate,
                'created_by' => auth()->id(),
                'notes' => $request->input('notes')
            ]
        );

        \Illuminate\Support\Facades\Cache::forget("exchange_rate_{$business_id}_{$request->from_currency_id}_{$request->to_currency_id}");
        \Illuminate\Support\Facades\Cache::forget("exchange_rate_{$business_id}_{$request->to_currency_id}_{$request->from_currency_id}");

        $output = [
            'success' => true,
            'msg' => 'Tasa de cambio guardada exitosamente'
        ];

        return redirect()->route('exchange-rates.index')->with('status', $output);
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit_exchange_rate')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id') ?: 1;
        $rate = ExchangeRate::where('business_id', $business_id)->findOrFail($id);
        $currencies = Currency::pluck('currency', 'id');

        return view('exchange_rates.edit', compact('rate', 'currencies'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('edit_exchange_rate')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id') ?: 1;
        $exchangeRate = ExchangeRate::where('business_id', $business_id)->findOrFail($id);

        $effective_date = $this->parseDate($request->input('effective_date'));
        $rate = $this->parseRate($request->input('rate'));

        if ($rate <= 0) {
            return redirect()->back()->withInput()->with('status', [
                'success' => false,
                'msg' => 'La tasa de cambio debe ser un número mayor a 0.'
            ]);
        }

        if (!$request->input('from_currency_id') || !$request->input('to_currency_id')) {
            return redirect()->back()->withInput()->with('status', [
                'success' => false,
                'msg' => 'Debe seleccionar la moneda de origen y la moneda de destino.'
            ]);
        }

        if ($request->input('from_currency_id') == $request->input('to_currency_id')) {
            return redirect()->back()->withInput()->with('status', [
                'success' => false,
                'msg' => 'La moneda de origen y destino no pueden ser iguales.'
            ]);
        }

        $exchangeRate->update([
            'from_currency_id' => $request->input('from_currency_id'),
            'to_currency_id' => $request->input('to_currency_id'),
            'rate' => $rate,
            'effective_date' => $effective_date,
            'notes' => $request->input('notes')
        ]);

        \Illuminate\Support\Facades\Cache::forget("exchange_rate_{$business_id}_{$request->from_currency_id}_{$request->to_currency_id}");
        \Illuminate\Support\Facades\Cache::forget("exchange_rate_{$business_id}_{$request->to_currency_id}_{$request->from_currency_id}");

        $output = [
            'success' => true,
            'msg' => 'Tasa de cambio actualizada exitosamente'
        ];

        return redirect()->route('exchange-rates.index')->with('status', $output);
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete_exchange_rate')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            $rate = ExchangeRate::where('business_id', $business_id)->findOrFail($id);
            $rate->delete();

            $output = [
                'success' => true,
                'msg' => 'Tasa de cambio eliminada exitosamente'
            ];
        } catch (\Exception $e) {
            $output = [
                'success' => false,
                'msg' => 'Error al eliminar la tasa de cambio: ' . $e->getMessage()
            ];
        }

        // Si es una petición AJAX, devolver JSON
        if (request()->ajax()) {
            return response()->json($output);
        }

        // Si no es AJAX, redirigir
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

    /**
     * Actualizar tasa desde DolarApi.com (botón manual)
     */
    public function syncFromApi(Request $request)
    {
        try {
            $business_id = $request->session()->get('user.business_id') ?: 1;
            $source = $request->input('source', 'oficial');

            $service = new \App\Services\ExchangeRateService();
            $result = $service->updateRate($business_id, $source, auth()->id());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($result);
            }

            $output = [
                'success' => $result['success'],
                'msg' => $result['message'],
            ];

            return redirect()->route('exchange-rates.index')->with('status', $output);
        } catch (\Exception $e) {
            \Log::error('Error syncFromApi: ' . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al sincronizar tasa: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('exchange-rates.index')->with('status', [
                'success' => false,
                'msg' => 'Error al sincronizar tasa: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Obtener tasa actual desde la API sin guardar (preview)
     */
    public function previewApiRate()
    {
        $service = new \App\Services\ExchangeRateService();
        $data = $service->fetchFromApi();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo consultar DolarApi.com',
            ]);
        }

        return response()->json([
            'success' => true,
            'oficial' => $data['oficial'],
            'paralelo' => $data['paralelo'],
            'fecha' => $data['fecha'],
        ]);
    }
}
