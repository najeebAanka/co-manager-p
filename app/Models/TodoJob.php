<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TodoJob
 * 
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $current_status
 * @property int|null $parent_id
 * @property int|null $assigned_to
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property string|null $created_by
 * @property int|null $department_id
 * @property int|null $duration_required
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TodoJob extends Model
{
	protected $table = 'todo_jobs';

	protected $casts = [
		'parent_id' => 'int',
		'assigned_to' => 'int',
		'start_date' => 'datetime',
		'end_date' => 'datetime',
		'department_id' => 'int',
		'duration_required' => 'int'
	];

	protected $fillable = [
		'title',
		'description',
		'current_status',
		'parent_id',
		'assigned_to',
		'start_date',
		'end_date',
		'created_by',
		'department_id',
		'duration_required',
		'task_file',
	];

	public function buildFile(){
		// return $this->task_file!="" ? asset('storage/tasks/files/'.$this->task_file):url('dist/assets/img/empty.png');
		return $this->task_file!="" ? asset('storage/tasks/files/'.$this->task_file):null;
	 }

}
