<?php

/**
 * Properties Model
 *
 * Properties Model manages Properties operation.
 *
 * @category   Properties
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.7
 * @link       http://techvill.net
 * @since      Version 1.3
 * @deprecated None
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyPhotos;
use App\Models\PropertyDates;
use Illuminate\Database\Eloquent\SoftDeletes;


class Properties extends Model
{
    protected $table = 'properties';
    use SoftDeletes;

    protected $appends = ['steps_completed','space_type_name','property_type_name','property_photo','host_name', 'reviews_count', 'overall_rating', 'cover_photo','avg_rating'];


    public static function recommendedHome()
    {
        $data = parent::where('status', 'listed')
                        ->with('users','property_price', 'property_address')
                        ->where('recomended', '1')
                        ->take(8)
                        ->inRandomOrder()
                        ->get();           
        return $data;
    }


    public function getHostNameAttribute()
    {
        $result = User::where('id', $this->attributes['host_id'])->first();
        return $result->first_name;
    }

    public function getHostImageAttribute()
    {
        $result = User::where('id', $this->attributes['host_id'])->first();
        return $result->profile_image;

        
    }

    public function getPropertyPhotoAttribute()
    {
        $result = PropertyPhotos::where('property_id', $this->attributes['id'])->first();
        return (isset($result->photo) ? $result->photo : '') ;
    }

    public function getPropertyTypeNameAttribute()
    {
        $result = PropertyType::where('id', $this->attributes['property_type'])->first();
        return $result->name;
    }

    public function getSpaceTypeNameAttribute()
    {
        $result = SpaceType::where('id', $this->attributes['space_type'])->first();
        return $result->name;
    }

    public function getStepsCompletedAttribute()
    {
        $result = PropertySteps::where('property_id', $this->attributes['id'])->first();
        
        if ($this->attributes['amenities'] == NULL) {
            $amenities = 0;
        } else {
            $amenities = 1;
        }

        return 7 - ($result->basics + $result->description + $result->location + $result->photos + $result->pricing + $result->booking + $amenities);
    }

    public function getMissedStepAttribute()
    {
        $result = PropertySteps::where('property_id', $this->attributes['id'])->first()->toArray();
        $discard = [ 'id', 'property_id'];
        $fl = '';
        foreach ($result as $key => $value) {
            if (!in_array($key, $discard) && $value == 0) {
                $fl = $key;
                break;
            }
        }
        return $fl;
    }

    public function bookings()
    {
        return $this->hasMany('App\Models\Bookings', 'property_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Messages', 'property_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'host_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Reviews', 'property_id', 'id');
    }

    public function property_type()
    {
        return $this->belongsTo('App\Models\PropertyType', 'property_type', 'id');
    }

    public function property_address()
    {
        return $this->hasOne('App\Models\PropertyAddress', 'property_id', 'id');
    }

    public function property_beds()
    {
        return $this->hasMany('App\Models\PropertyBeds', 'property_id', 'id');
    }

    public function property_dates()
    {
        return $this->hasMany('App\Models\PropertyDates', 'property_id', 'id');
    }

    public function property_description()
    {
        return $this->hasOne('App\Models\PropertyDescription', 'property_id', 'id');
    }

    public function property_details()
    {
        return $this->hasMany('App\Models\PropertyDetails', 'property_id', 'id');
    }

    public function property_price()
    {
        return $this->hasOne('App\Models\PropertyPrice', 'property_id', 'id');
    }

    public function property_photos()
    {
        return $this->hasMany('App\Models\PropertyPhotos', 'property_id', 'id');
    }
    
    public function property_rules()
    {
        return $this->hasMany('App\Models\PropertyRules', 'property_id', 'id');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Reports', 'property_id', 'id');
    }

    public function steps()
    {
        return $this->hasOne('App\Models\PropertySteps', 'property_id', 'id');
    }

    public function bed_types()
    {
        return $this->belongsTo('App\Models\BedType', 'bed_type', 'id');
    }

    public function getCoverPhotoAttribute()
    {
        $cover = PropertyPhotos::where('property_id', $this->attributes['id'])->where('cover_photo', 1)->first();
        if (isset($cover->photo)) {
            $url = url('public/images/property/'.$this->attributes['id'].'/'.$cover->photo);
        } else {
            $url = url('public/images/default-image.png');
        }
        return $url;
    }

    public function getLatestProperties()
    {
        $query = Properties::join('users', function ($join) {
                                $join->on('users.id', '=', 'properties.host_id');
        })
                        ->join('space_type', function ($join) {
                                $join->on('space_type.id', '=', 'properties.space_type');
                        })
                        ->join('property_type', function ($join) {
                                $join->on('property_type.id', '=', 'properties.property_type');
                        })

                        ->select(['properties.id as properties_id', 'properties.name as property_name', 'properties.status as property_status', 'properties.created_at as property_created_at', 'properties.updated_at as property_updated_at', 'properties.*', 'users.*', 'property_type.*', 'space_type.*'])
                        ->take(5)
                        ->orderBy('properties.created_at', 'desc')
                        ->get();
                       
        return $query;
    }


  
    public function getReviewsCountAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id']);

        return $reviews->count();
    }

     public function getGuestReviewAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');

        return $reviews->count();
    }

    public function getOverallRatingAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');

        $avg     = @($reviews->sum('rating') / $reviews->count());

        if ($avg) {
            $sum   = 0;
            $whle  = floor($avg);
            $fract = $avg - $whle;
            for ($i=0; $i<$whle; $i++) {
                $sum += 25;
            }

            if ($fract >= 0.5) {
                $sum += 12;
            }

            return $sum;
        } else {
            return 0;
        }
    }

    public function getAvgRatingAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');
        $avg = 0;
        if( $reviews->count()){
            $avg     = $reviews->sum('rating') / $reviews->count();
        }
        return $avg;
    }


    public function getAccuracyRatingAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');
        $avg     = ($reviews->sum('accuracy') / $reviews->count());

        if ($avg) {
            $sum   = 0;

            $whle = floor($avg);
            $fract = $avg - $whle;

            for ($i=0; $i<$whle; $i++) {
                $sum += 25;
            }

            if ($fract >= 0.5) {
                $sum += 12;
            }

            return $sum;
        } else {
            return 0;
        }
    }


    public function getAccuracyAvgRatingAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');

        $avg = 0;
        if( $reviews->count()){
            $avg     = ($reviews->sum('accuracy') / $reviews->count());
        }
        return $avg;
    }





    public function getLocationRatingAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');
        $avg     = ($reviews->sum('location') / $reviews->count());

        if ($avg) {
            $sum   = 0;
            $whle  = floor($avg);
            $fract = $avg - $whle;

            for ($i=0; $i<$whle; $i++) {
                $sum += 25;
            }

            if ($fract >= 0.5) {
                $sum += 12;
            }
            
            
            return $sum;
        } else {
            return 0;
        }
    }

    public function getLocationAvgRatingAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');

        $avg = 0;
        if( $reviews->count()){
            $avg     = ($reviews->sum('location') / $reviews->count());
        }
        return $avg;
    }

    public function getCommunicationRatingAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');
        $avg     = ($reviews->sum('communication') / $reviews->count());

        if ($avg) {
            $sum  = 0;

            $whle = floor($avg);
            $fract = $avg - $whle;

            for ($i=0; $i<$whle; $i++) {
                $sum += 25;
            }

            if ($fract >= 0.5) {
                $sum += 12;
            }
            
            
            return $sum;
        } else {
            return 0;
        }
    }

    public function getCommunicationAvgRatingAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');

        $avg = 0;
        if( $reviews->count()){
            $avg     = ($reviews->sum('communication') / $reviews->count());
        }
        return $avg;
    }

    public function getCheckinRatingAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');

        $avg     = ($reviews->sum('checkin') / $reviews->count());

        if ($avg) {
            $sum   = 0;
            $whle  = floor($avg);
            $fract = $avg - $whle;

            for ($i=0; $i<$whle; $i++) {
                $sum += 25;
            }

            if ($fract >= 0.5) {
                $sum += 12;
            }
            
            return $sum;
        } else {
            return 0;
        }
    }

    public function getCheckinAvgRatingAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');

        $avg = 0;
        if( $reviews->count()){
            $avg     = ($reviews->sum('checkin') / $reviews->count());
        }
        return $avg;
    }

    public function getCleanlinessRatingAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');
        $avg     = ($reviews->sum('cleanliness') / $reviews->count());

        if ($avg) {
            $sum   = 0;
            $whle  = floor($avg);
            $fract = $avg - $whle;

            for ($i=0; $i<$whle; $i++) {
                $sum += 25;
            }

            if ($fract >= 0.5) {
                $sum += 12;
            }
            
            return $sum;
        } else {
            return 0;
        }
    }

    public function getCleanlinessAvgRatingAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');

        $avg = 0;
        if( $reviews->count()){
            $avg     = ($reviews->sum('cleanliness') / $reviews->count());
        }
        return $avg;
    }

    public function getValueRatingAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');

        $avg     = ($reviews->sum('value') / $reviews->count());

        if ($avg) {
            $sum   = 0;
            $whle  = floor($avg);
            $fract = $avg - $whle;

            for ($i=0; $i<$whle; $i++) {
                $sum += 25;
            }

            if ($fract >= 0.5) {
                $sum += 12;
            }
            
            return $sum;
        } else {
            return 0;
        }
    }

    public function getValueAvgRatingAttribute()
    {
        $reviews = Reviews::where('property_id', $this->attributes['id'])->where('reviewer', 'guest');

        $avg = 0;
        if( $reviews->count()){
            $avg     = ($reviews->sum('value') / $reviews->count());
        }
        return $avg;
    }
}
