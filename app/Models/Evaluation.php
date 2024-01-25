<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Evaluation
 * 
 * @property int $id
 * @property int|null $standard_id
 * @property int|null $max_score
 * @property int|null $current_score
 * @property int|null $eval_by
 * @property int|null $eval_to
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Evaluation extends Model
{
	protected $table = 'evaluations';

	protected $casts = [
		'standard_id' => 'int',
		'max_score' => 'int',
		'current_score' => 'int',
		'eval_by' => 'int',
		'eval_to' => 'int'
	];

	protected $fillable = [
		'standard_id',
		'max_score',
		'current_score',
		'eval_by',
		'eval_to',
		'notes'
	];
}
