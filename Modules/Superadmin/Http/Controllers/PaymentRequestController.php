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
                    'info' => '<strong>Contáctanos:</strong><br>WhatsApp: +584242909870<br>Email: edduar@kubre.site<br>Telegram: @evill_etherven'
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

    public function approve(Request $request, $id)
    {
        $paymentRequest = PaymentRequest::findOrFail($id);
        
        // Verificar si ya fue aprobado
        if ($paymentRequest->status == 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Esta solicitud ya fue aprobada anteriormente'
            ]);
        }

        // Validar contraseña
        $password = $request->input('password', 'password123');
        if (strlen($password) < 6) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña debe tener al menos 6 caracteres'
            ]);
        }

        // Buscar si el negocio ya existe por email
        $user = \App\Models\User::where('email', $paymentRequest->email)->first();
        
        if (!$user) {
            // Crear nuevo negocio y usuario
            $business = \App\Models\Business::create([
                'name' => $paymentRequest->business_name,
                'currency_id' => 1, // USD por defecto, ajusta según necesites
                'start_date' => now()->toDateString(),
                'default_profit_percent' => 25,
                'time_zone' => config('app.timezone'),
                'fy_start_month' => 1,
            ]);

            // Crear usuario propietario con la contraseña proporcionada
            $user = \App\Models\User::create([
                'surname' => $paymentRequest->contact_name,
                'first_name' => '',
                'username' => $this->generateUsername($paymentRequest->email),
                'email' => $paymentRequest->email,
                'password' => bcrypt($password),
                'language' => 'es',
                'business_id' => $business->id,
                'is_superadmin' => 0,
            ]);

            // Asignar rol de admin al usuario
            $user->assignRole('Admin#' . $business->id);
        } else {
            $business = $user->business;
        }

        // Crear la suscripción usando el método del sistema
        $baseController = new \Modules\Superadmin\Http\Controllers\BaseController();
        
        $subscription = $baseController->_add_subscription(
            null, // código de cupón
            $paymentRequest->amount, // precio
            $business->id, // business_id
            $paymentRequest->package, // package
            'manual', // gateway (pago manual)
            $paymentRequest->reference_number, // transaction_id
            $user->id, // user_id
            true // is_superadmin (para que se apruebe automáticamente)
        );

        // Actualizar el estado de la solicitud
        $paymentRequest->status = 'approved';
        $paymentRequest->approved_at = now();
        $paymentRequest->admin_notes = 'Suscripción creada automáticamente. Business ID: ' . $business->id . ', Subscription ID: ' . $subscription->id . ', Email: ' . $user->email;
        $paymentRequest->save();

        return response()->json([
            'success' => true,
            'message' => 'Pago aprobado y suscripción creada exitosamente',
            'business_id' => $business->id,
            'subscription_id' => $subscription->id,
            'email' => $user->email,
            'username' => $user->username
        ]);
    }

    private function generateUsername($email)
    {
        $username = explode('@', $email)[0];
        $username = preg_replace('/[^a-zA-Z0-9]/', '', $username);
        
        // Verificar si el username ya existe
        $count = \App\Models\User::where('username', 'like', $username . '%')->count();
        
        if ($count > 0) {
            $username = $username . ($count + 1);
        }
        
        return $username;
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
