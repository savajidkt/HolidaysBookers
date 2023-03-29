<?php

namespace App\Models;

use App\Models\City;
use App\Models\PackageInclusion;
use App\Models\PackageExclusion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;
    const ACTIVE = 1;
    const INACTIVE = 0;


    const STATUS = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive'
    ];

    //protected $table = "packages";
    protected $fillable = [
        'package_name',
        'package_code',
        'valid_from',
        'valid_till',
        'nationality',
        'rate_per_adult',
        'rate_per_child_cwb',
        'rate_per_child_cnb',
        'rate_per_infant',
        'minimum_pax',
        'maximum_pax',
        'cancel_day',
        'terms_and_conditions_pdf',
        'status',
        'highlights',
        'terms_and_conditions'
    ];

    /**
     * Method getActionAttribute
     *
     * @return string
     */
    public function getActionAttribute(): string
    {
        $admin = auth()->user();
        $action = '';
        $viewAction =  '<a href="' . route('packages.show', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="View" data-animation="false"><i class="fa fa-eye" aria-hidden="true"></i></a> ';
        $editAction = '<a href="' . route('packages.edit', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="' . __('core.edit') . '" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a> ';

        if ($admin->can('reach-us-edit')) {
            $action .= $editAction;
        }
        if ($admin->can('reach-us-view')) {
            $action .= $viewAction;
        }

        if ($admin->can('reach-us-delete')) {
            $action .= $this->getDeleteButtonAttribute();
        }
        return $action;
    }

    /**
     * Get Delete Button Attribute
     *
     * @param string $class
     * @return string
     */
    public function getDeleteButtonAttribute($class = '')
    {
        return '<a href="' . route('packages.destroy', $this) . '" class="delete_action btn btn-danger btn-sm" data-method="delete" data-toggle="tooltip" data-original-title="' . __('core.delete') . '" data-animation="false"><i class="fa fa-trash" aria-hidden="true"></i></a>';
    }


    /**
     * Method getStatusAttribute
     *
     * @return string
     */
    public function getStatusNameAttribute(): string
    {
        $status = self::ACTIVE;
        switch ($this->status) {
            case self::INACTIVE:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger status_update" data-package_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.inactive') . '</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success status_update" data-package_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.active') . '</span></a>';
                break;
        }
        return $status;
    }


    public function origincity()
    {
        return $this->belongsToMany(Package::class, 'package_origin_cities', 'package_id', 'city_name');
    }
    public function origincityname()
    {
        return $this->hasMany(PackageOriginCity::class, 'package_id', 'id');
    }
    public function inclusionname()
    {
        return $this->hasMany(PackageInclusion::class, 'package_id', 'id');
    }
    public function exclusionname()
    {
        return $this->hasMany(PackageExclusion::class, 'package_id', 'id');
    }

    public function packageitineraries()
    {
        return $this->hasMany(PackageItineraries::class, 'package_id', 'id');
    }


    public function inclusion()
    {
        return $this->belongsToMany(Package::class, 'package_inclusions', 'package_id', 'inclusion_name');
    }
    public function exclusion()
    {
        return $this->belongsToMany(Package::class, 'package_exclusions', 'package_id', 'exclusion_name');
    }
    public function packageimages()
    {
        return $this->hasMany(PackageGallery::class, 'package_id', 'id');
    }

    public function packagecity()
    {
        return $this->belongsToMany(City::class, 'package_cities', 'package_id', 'city_id');
    }

    public function packagecountry()
    {
        return $this->belongsToMany(Country::class, 'package_countries', 'package_id', 'country_id');
    }
    public function getCityNameAttribute(): string
    {
        return implode(',', $this->packagecity->pluck('name')->toArray());
    }
    public function getCountryNameAttribute(): string
    {
        return implode(',', $this->packagecountry->pluck('name')->toArray());
    }
}
