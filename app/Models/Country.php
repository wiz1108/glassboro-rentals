<?php

/**
 * Country Model
 *
 * Country Model manages Country operation.
 *
 * @category   Language
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
use Cache;


class Country extends Model
{
    protected $table   = 'country';
    public $timestamps = false;

    public static function getAll()
    {
        $data = Cache::get('vr-countries');
        if (empty($data)) {
            $data = parent::all();
            Cache::put('vr-countries', $data, 86400);
        }
        return $data;
    }

    public function property_address()
    {
        return $this->hasMany('App\Models\PropertyAddress', 'country', 'short_name');
    }
}
