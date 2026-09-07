<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;
    use HasApiTokens;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'active_session_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'cmmsn_tiered_rules' => 'array',
        'cmmsn_percent' => 'float',
    ];

    /**
     * Obtener el porcentaje de comisión aplicable según los días transcurridos
     *
     * @param int $days
     * @return float
     */
    public function getCommissionPercentageForDays($days = 0): float
    {
        if ($this->cmmsn_type === 'tiered' && !empty($this->cmmsn_tiered_rules) && is_array($this->cmmsn_tiered_rules)) {
            foreach ($this->cmmsn_tiered_rules as $rule) {
                $min = isset($rule['min_days']) && $rule['min_days'] !== '' ? (int)$rule['min_days'] : 0;
                $max = isset($rule['max_days']) && $rule['max_days'] !== '' && $rule['max_days'] !== null ? (int)$rule['max_days'] : null;
                $pct = isset($rule['percent']) ? (float)$rule['percent'] : 0;

                if ($days >= $min && ($max === null || $days <= $max)) {
                    return $pct;
                }
            }
        }

        return (float) ($this->cmmsn_percent ?? 0);
    }

    /**
     * Calcular monto de comisión para un pago según los días
     *
     * @param int $days
     * @param float $amount
     * @return array ['percentage' => float, 'commission_amount' => float]
     */
    public function calculateCommissionForPayment($days = 0, $amount = 0): array
    {
        $percentage = $this->getCommissionPercentageForDays($days);
        $commission_amount = ($amount * $percentage) / 100;

        return [
            'percentage' => $percentage,
            'commission_amount' => $commission_amount,
        ];
    }

    /**
     * Calcular solo el monto numérico de comisión para un pago
     *
     * @param int $days
     * @param float $amount
     * @return float
     */
    public function calculateCommissionAmount($days = 0, $amount = 0): float
    {
        $percentage = $this->getCommissionPercentageForDays($days);
        return (float) (($amount * $percentage) / 100);
    }

    /**
     * Get the business that owns the user.
     */
    public function business()
    {
        return $this->belongsTo(\App\Business::class);
    }

    public function scopeUser($query)
    {
        return $query->where('users.user_type', 'user');
    }

    /**
     * The contact the user has access to.
     * Applied only when selected_contacts is true for a user in
     * users table
     */
    public function contactAccess()
    {
        return $this->belongsToMany(\App\Contact::class, 'user_contact_access');
    }

    /**
     * Get all of the users's notes & documents.
     */
    public function documentsAndnote()
    {
        return $this->morphMany(\App\DocumentAndNote::class, 'notable');
    }

    /**
     * Creates a new user based on the input provided.
     *
     * @return object
     */
    public static function create_user($details)
    {
        $user = User::create([
            'surname' => $details['surname'],
            'first_name' => $details['first_name'],
            'last_name' => $details['last_name'],
            'username' => $details['username'],
            'email' => $details['email'],
            'password' => Hash::make($details['password']),
            'language' => ! empty($details['language']) ? $details['language'] : 'en',
        ]);

        return $user;
    }

    /**
     * Gives locations permitted for the logged in user
     *
     * @param: int $business_id
     *
     * @return string or array
     */
    public function permitted_locations($business_id = null)
    {
        $user = $this;

        if ($user->can('access_all_locations')) {
            return 'all';
        } else {
            $business_id = ! is_null($business_id) ? $business_id : null;
            if (empty($business_id) && auth()->check()) {
                $business_id = auth()->user()->business_id;
            }
            if (empty($business_id) && session()->has('business')) {
                $business_id = session('business.id');
            }

            $permitted_locations = [];
            $all_locations = BusinessLocation::where('business_id', $business_id)->get();
            $permissions = $user->permissions->pluck('name')->all();
            foreach ($all_locations as $location) {
                if (in_array('location.'.$location->id, $permissions)) {
                    $permitted_locations[] = $location->id;
                }
            }

            return $permitted_locations;
        }
    }

    /**
     * Returns if a user can access the input location
     *
     * @param: int $location_id
     *
     * @return bool
     */
    public static function can_access_this_location($location_id, $business_id = null)
    {
        $permitted_locations = auth()->user()->permitted_locations($business_id);

        if ($permitted_locations == 'all' || in_array($location_id, $permitted_locations)) {
            return true;
        }

        return false;
    }

    public function scopeOnlyPermittedLocations($query)
    {
        $user = auth()->user();
        $permitted_locations = $user->permitted_locations();
        $is_admin = $user->hasAnyPermission('Admin#'.$user->business_id);
        if ($permitted_locations != 'all' && ! $user->can('superadmin') && ! $is_admin) {
            $permissions = ['access_all_locations'];
            foreach ($permitted_locations as $location_id) {
                $permissions[] = 'location.'.$location_id;
            }

            return $query->whereHas('permissions', function ($q) use ($permissions) {
                $q->whereIn('permissions.name', $permissions);
            });
        } else {
            return $query;
        }
    }

    /**
     * Return list of users dropdown for a business
     *
     * @param $business_id int
     * @param $prepend_none = true (boolean)
     * @param $include_commission_agents = false (boolean)
     * @return array users
     */
    public static function forDropdown($business_id, $prepend_none = true, $include_commission_agents = false, $prepend_all = false, $check_location_permission = false)
    {
        $query = User::where('business_id', $business_id)
                    ->user();

        if (! $include_commission_agents) {
            $query->where('is_cmmsn_agnt', 0);
        }

        if ($check_location_permission) {
            $query->onlyPermittedLocations();
        }

        $all_users = $query->select('id', DB::raw("CONCAT(COALESCE(surname, ''),' ',COALESCE(first_name, ''),' ',COALESCE(last_name,'')) as full_name"))->get();
        $users = $all_users->pluck('full_name', 'id');

        //Prepend none
        if ($prepend_none) {
            $users = $users->prepend(__('lang_v1.none'), '');
        }

        //Prepend all
        if ($prepend_all) {
            $users = $users->prepend(__('lang_v1.all'), '');
        }

        return $users;
    }

    /**
     * Return list of sales commission agents dropdown for a business
     *
     * @param $business_id int
     * @param $prepend_none = true (boolean)
     * @return array users
     */
    public static function saleCommissionAgentsDropdown($business_id, $prepend_none = true)
    {
        $all_cmmsn_agnts = User::where('business_id', $business_id)
                        ->where('is_cmmsn_agnt', 1)
                        ->select('id', DB::raw("CONCAT(COALESCE(surname, ''),' ',COALESCE(first_name, ''),' ',COALESCE(last_name,'')) as full_name"));

        $users = $all_cmmsn_agnts->pluck('full_name', 'id');

        //Prepend none
        if ($prepend_none) {
            $users = $users->prepend(__('lang_v1.none'), '');
        }

        return $users;
    }

    /**
     * Return list of users dropdown for a business
     *
     * @param $business_id int
     * @param $prepend_none = true (boolean)
     * @param $prepend_all = false (boolean)
     * @return array users
     */
    public static function allUsersDropdown($business_id, $prepend_none = true, $prepend_all = false)
    {
        $all_users = User::where('business_id', $business_id)
                        ->select('id', DB::raw("CONCAT(COALESCE(surname, ''),' ',COALESCE(first_name, ''),' ',COALESCE(last_name,'')) as full_name"));

        $users = $all_users->pluck('full_name', 'id');

        //Prepend none
        if ($prepend_none) {
            $users = $users->prepend(__('lang_v1.none'), '');
        }

        //Prepend all
        if ($prepend_all) {
            $users = $users->prepend(__('lang_v1.all'), '');
        }

        return $users;
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getUserFullNameAttribute()
    {
        return "{$this->surname} {$this->first_name} {$this->last_name}";
    }

    /**
     * Return true/false based on selected_contact access
     *
     * @return bool
     */
    public static function isSelectedContacts($user_id)
    {
        $user = User::findOrFail($user_id);

        return (bool) $user->selected_contacts;
    }

    public function getRoleNameAttribute()
    {
        $role_name_array = $this->getRoleNames();
        $role_name = ! empty($role_name_array[0]) ? explode('#', $role_name_array[0])[0] : '';

        return $role_name;
    }

    public function media()
    {
        return $this->morphOne(\App\Media::class, 'model');
    }

    /**
     * Find the user instance for the given username.
     *
     * @param  string  $username
     * @return \App\User
     */
    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Get the contact for the user.
     */
    public function contact()
    {
        return $this->belongsTo(\Modules\Crm\Entities\CrmContact::class, 'crm_contact_id');
    }

    /**
     * Get the products image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (isset($this->media->display_url)) {
            $img_src = $this->media->display_url;
        } else {
            $img_src = 'https://ui-avatars.com/api/?name='.$this->first_name;
        }

        return $img_src;
    }
}
