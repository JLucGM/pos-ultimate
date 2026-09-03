<?php

namespace Modules\Superadmin\Http\Controllers;

use App\System;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Entities\Package;
use Modules\Superadmin\Entities\Subscription;
use Modules\Superadmin\Notifications\NewSubscriptionNotification;
use Notification;

class BaseController extends Controller
{
    /**
     * Returns the list of all configured payment gateway
     *
     * @return Response
     */
    public function _payment_gateways()
    {
        $gateways = [];

        // 1. Pago Móvil (VES Bs.)
        $enable_pagomovil = System::getProperty('enable_pagomovil');
        if ($enable_pagomovil === null || $enable_pagomovil == 1) {
            $gateways['pagomovil'] = 'Pago Móvil (VES Bs.)';
        }

        // 2. Transferencia Bancaria Nacional (VES / USD)
        $enable_bank_transfer = System::getProperty('enable_bank_transfer');
        if ($enable_bank_transfer === null || $enable_bank_transfer == 1) {
            $gateways['bank_transfer'] = 'Transferencia Bancaria Nacional';
        }

        // 3. Zelle (USD)
        $enable_zelle = System::getProperty('enable_zelle');
        if ($enable_zelle === null || $enable_zelle == 1) {
            $gateways['zelle'] = 'Zelle (Dólares USD)';
        }

        // 4. Binance Pay / USDT
        $enable_binance = System::getProperty('enable_binance');
        if ($enable_binance === null || $enable_binance == 1) {
            $gateways['binance'] = 'Binance Pay / USDT';
        }

        // 5. PayPal (USD)
        $enable_paypal = System::getProperty('enable_paypal');
        if ($enable_paypal === null || $enable_paypal == 1) {
            $gateways['paypal'] = 'PayPal';
        }

        return $gateways;
    }

    /**
     * Enter details for subscriptions
     *
     * @return object
     */
    public function _add_subscription($code, $price, $business_id, $package, $gateway, $payment_transaction_id, $user_id, $is_superadmin = false, $custom_package_details = [])
    {
        if (! is_object($package)) {
            $package = Package::active()->find($package);
        }

        $subscription = ['business_id' => $business_id,
            'package_id' => $package->id,
            'paid_via' => $gateway,
            'payment_transaction_id' => $payment_transaction_id,
        ];

        $manual_gateways = ['offline', 'pagomovil', 'bank_transfer', 'zelle', 'binance', 'paypal'];
        if ($package->price != 0 && (in_array($gateway, $manual_gateways) && ! $is_superadmin)) {
            //If offline/manual report then dates will be decided when approved by superadmin
            $subscription['start_date'] = null;
            $subscription['end_date'] = null;
            $subscription['trial_end_date'] = null;
            $subscription['status'] = 'waiting';
        } else {
            $dates = $this->_get_package_dates($business_id, $package);

            $subscription['start_date'] = $dates['start'];
            $subscription['end_date'] = $dates['end'];
            $subscription['trial_end_date'] = $dates['trial'];
            $subscription['status'] = 'approved';
        }

        $subscription['package_price'] = empty($code) ? $package->price : $price;
        $subscription['coupon_code'] = $code;
        $subscription['original_price'] = $package->price;
        $subscription['package_details'] = [
            'location_count' => $package->location_count,
            'user_count' => $package->user_count,
            'product_count' => $package->product_count,
            'invoice_count' => $package->invoice_count,
            'name' => $package->name,
            'bookings' => $package->bookings ?? 0,
            'kitchen' => $package->kitchen ?? 0,
            'order_screen' => $package->order_screen ?? 0,
            'tables' => $package->tables ?? 0,
        ];
        //Custom permissions.
        if (! empty($package->custom_permissions)) {
            foreach ($package->custom_permissions as $name => $value) {
                $subscription['package_details'][$name] = $value;
            }
        }

        // Additional package details (such as offline payment report)
        if (! empty($custom_package_details)) {
            foreach ($custom_package_details as $key => $val) {
                $subscription['package_details'][$key] = $val;
            }
        }

        $subscription['created_id'] = $user_id;
        $subscription = Subscription::create($subscription);

        // If newly created subscription is approved and paid, terminate any previous trial subscription
        if ($subscription->status == 'approved' && $subscription->paid_via != 'trial') {
            Subscription::where('business_id', $business_id)
                ->where('id', '!=', $subscription->id)
                ->where('paid_via', 'trial')
                ->where('status', 'approved')
                ->update([
                    'end_date' => \Carbon\Carbon::yesterday()->toDateString(),
                ]);
        }

        if (! $is_superadmin) {
            $email = System::getProperty('email');
            $is_notif_enabled = System::getProperty('enable_new_subscription_notification');

            if (! empty($email) && $is_notif_enabled == 1) {
                Notification::route('mail', $email)
                ->notify(new NewSubscriptionNotification($subscription));
            }
        }

        return $subscription;
    }

    /**
     * The function returns the start/end/trial end date for a package.
     *
     * @param  int  $business_id
     * @param  object  $package
     * @return array
     */
    protected function _get_package_dates($business_id, $package)
    {
        $output = ['start' => '', 'end' => '', 'trial' => ''];

        //calculate start date
        $start_date = Subscription::end_date($business_id);
        $output['start'] = $start_date->toDateString();

        //Calculate end date
        if ($package->interval == 'days') {
            $output['end'] = $start_date->addDays($package->interval_count)->toDateString();
        } elseif ($package->interval == 'months') {
            $output['end'] = $start_date->addMonths($package->interval_count)->toDateString();
        } elseif ($package->interval == 'years') {
            $output['end'] = $start_date->addYears($package->interval_count)->toDateString();
        }

        $output['trial'] = $start_date->addDays($package->trial_days);

        return $output;
    }
}
