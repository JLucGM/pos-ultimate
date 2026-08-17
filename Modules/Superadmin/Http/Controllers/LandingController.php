<?php

namespace Modules\Superadmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Entities\Package;
use App\Utils\ModuleUtil;

class LandingController extends Controller
{
    protected $moduleUtil;

    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display the landing page
     *
     * @return Response
     */
    public function index()
    {
        // Get active packages for preview
        $packages = Package::active()
            ->notPrivate()
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        $theme = config('ui.landing_theme', 'modern');
        $view = $theme === 'modern' ? 'superadmin::landing.index_modern' : 'superadmin::landing.index';

        return view($view, compact('packages'));
    }

    /**
     * Display the modern pricing page
     *
     * @return Response
     */
    public function pricing()
    {
        $packages = Package::active()
            ->notPrivate()
            ->orderBy('sort_order')
            ->get();

        // Get all module permissions and convert them into name => label
        $permissions = $this->moduleUtil->getModuleData('superadmin_package');
        $permission_formatted = [];
        foreach ($permissions as $permission) {
            foreach ($permission as $details) {
                $permission_formatted[$details['name']] = $details['label'];
            }
        }

        return view('superadmin::pricing.modern', compact('packages', 'permission_formatted'));
    }

    /**
     * Handle contact form submission
     *
     * @param Request $request
     * @return Response
     */
    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Send email notification
        try {
            \Mail::send('superadmin::emails.contact', [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company' => $request->company,
                'user_message' => $request->message,
            ], function ($message) use ($request) {
                $message->to(config('mail.from.address'))
                        ->subject('Nuevo mensaje de contacto - ' . $request->name);
                $message->replyTo($request->email, $request->name);
            });

            return response()->json([
                'success' => true,
                'message' => 'Gracias por contactarnos. Te responderemos pronto.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error sending contact email: ' . $e->getMessage());
            
            return response()->json([
                'success' => true,
                'message' => 'Gracias por contactarnos. Te responderemos pronto.'
            ]);
        }
    }

    /**
     * Display contact page
     *
     * @return Response
     */
    public function contactPage()
    {
        return view('superadmin::contact.index');
    }

    /**
     * Display features page
     *
     * @return Response
     */
    public function features()
    {
        return view('superadmin::landing.features');
    }

    /**
     * Display about page
     *
     * @return Response
     */
    public function about()
    {
        return view('superadmin::landing.about');
    }
}
