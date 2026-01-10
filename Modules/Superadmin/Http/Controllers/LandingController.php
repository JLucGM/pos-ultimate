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

        return view('superadmin::landing.index', compact('packages'));
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

        // Here you can add logic to send email or save to database
        // For now, we'll just return a success response

        return response()->json([
            'success' => true,
            'message' => 'Gracias por contactarnos. Te responderemos pronto.'
        ]);
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
