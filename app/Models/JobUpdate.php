<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JobUpdate
 * 
 * @property int $id
 * @property int|null $job_id
 * @property string|null $notes
 * @property int|null $created_by
 * @property int|null $working_duration
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class JobUpdate extends Model
{
	protected $table = 'job_updates';

	protected $casts = [
		'job_id' => 'int',
		'created_by' => 'int',
		'working_duration' => 'int'
	];

	protected $fillable = [
		'job_id',
		'notes',
		'created_by',
		'working_duration'
	];
}
