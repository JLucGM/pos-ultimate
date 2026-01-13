<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use Modules\Superadmin\Entities\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'business_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'payment_method' => 'required|in:transferencia,binance,paypal,pago movil,otro',
            'reference_number' => 'required|string|max:255',
            'payment_proof' => 'nullable|image|max:5120', // 5MB max
        ]);

        $package = Package::findOrFail($validated['package_id']);
        
        // Guardar el comprobante si existe
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment-proofs', 'public');
            $validated['payment_proof'] = $path;
        }

        $validated['amount'] = $package->price;
        $validated['status'] = 'pending';

        $paymentRequest = PaymentRequest::create($validated);

        return response()->json([
            'success' => true,
            'message' => '¡Solicitud de pago enviada! Te contactaremos pronto para confirmar tu suscripción.',
            'request_id' => $paymentRequest->id
        ]);
    }

    public function getPaymentInfo($packageId)
    {
        $package = Package::findOrFail($packageId);
        
        return response()->json([
            'package' => [
                'id' => $package->id,
                'name' => $package->name,
                'price' => $package->price,
                'currency' => $package->currency ?? '$',
            ],
            'payment_methods' => [
                'transferencia' => [
                    'name' => 'Transferencia Bancaria',
                    'info' => '<strong>Banco:</strong> Banco Mercantil <br><strong>Cuenta:</strong> 0105 0160 1111 6003 8953 <br><strong>Titular:</strong> Edduar Villegas<br><strong>RIF/CI:</strong> 13710797'
                ],
                'binance' => [
                    'name' => 'Binance Pay / USDT',
                    'info' => '<strong>Binance ID:</strong> @etherven<br><strong>Email:</strong> edduar.villegas@gmail.com<br><strong>Red:</strong> Binance Pay'
                ],
                'paypal' => [
                    'name' => 'PayPal',
                    'info' => '<strong>Email de PayPal:</strong> detoditollc@gmail.com<br><strong>Nota:</strong> Enviar como "Amigos y Familia" para evitar comisiones'
                ],
                'otro' => [
                    'name' => 'Otro Método',
                    'info' => '<strong>Contáctanos:</strong><br>WhatsApp: +584242909870<br>Email: edduar@audaz.site<br>Telegram: @evill_etherven'
                ]
            ]
        ]);
    }

    public function index()
    {
        $requests = PaymentRequest::with('package')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('superadmin::payment-requests.index', compact('requests'));
    }

    public function show($id)
    {
        $request = PaymentRequest::with('package')->findOrFail($id);
        return response()->json($request);
    }

    public function approve($id)
    {
        $paymentRequest = PaymentRequest::findOrFail($id);
        $paymentRequest->status = 'approved';
        $paymentRequest->approved_at = now();
        $paymentRequest->save();

        return response()->json(['success' => true]);
    }

    public function reject(Request $request, $id)
    {
        $paymentRequest = PaymentRequest::findOrFail($id);
        $paymentRequest->status = 'rejected';
        $paymentRequest->admin_notes = $request->input('reason');
        $paymentRequest->save();

        return response()->json(['success' => true]);
    }
}
