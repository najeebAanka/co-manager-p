<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EvalStandard
 * 
 * @property int $id
 * @property string|null $name_en
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $name_ar
 * @property string|null $icon
 *
 * @package App\Models
 */
class EvalStandard extends Model
{
	protected $table = 'eval_standards';

	protected $fillable = [
		'name_en',
		'name_ar',
		'icon'
	];

	public function getNameLocalized(){
        
           $lang = \Illuminate\Support\Facades\App::getLocale();
           if($lang == 'ar')return $this->name_ar;
           if($lang == 'en')return $this->name_en;
           return $this->name_en;
    } 
}
