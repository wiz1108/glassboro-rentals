<?php

/**
 * SpaceType Model
 *
 * SpaceType Model manages SpaceType operation.
 *
 * @category   SpaceType
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

class SpaceType extends Model
{
    protected $table   = 'space_type';
    public $timestamps = false;
}
