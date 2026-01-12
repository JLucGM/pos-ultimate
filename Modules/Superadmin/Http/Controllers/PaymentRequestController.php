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
            'payment_method' => 'required|in:transferencia,binance,paypal,otro',
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
                    'info' => '<strong>Banco:</strong> [Tu Banco Aquí]<br><strong>Cuenta:</strong> [Tu Número de Cuenta]<br><strong>Titular:</strong> [Tu Nombre]<br><strong>RIF/CI:</strong> [Tu RIF]'
                ],
                'binance' => [
                    'name' => 'Binance Pay / USDT',
                    'info' => '<strong>Binance ID:</strong> [Tu ID de Binance]<br><strong>Email:</strong> [Tu Email de Binance]<br><strong>Red:</strong> TRC20 o BEP20'
                ],
                'paypal' => [
                    'name' => 'PayPal',
                    'info' => '<strong>Email de PayPal:</strong> [Tu Email de PayPal]<br><strong>Nota:</strong> Enviar como "Amigos y Familia" para evitar comisiones'
                ],
                'otro' => [
                    'name' => 'Otro Método',
                    'info' => '<strong>Contáctanos:</strong><br>WhatsApp: [Tu WhatsApp]<br>Email: [Tu Email]<br>Telegram: [Tu Telegram]'
                ]
            ]
        ]);
    }
}
