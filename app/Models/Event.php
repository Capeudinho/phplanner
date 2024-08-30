<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
	use HasFactory;

	protected $fillable = [
		'title',
		'description',
		'start',
		'category_id',
		'user_id',
		'task_id',
		'goal_id',
	];

	public function user(): BelongsTo {
		return $this->belongsTo(User::class, 'user_id');
	}

	public function category(): BelongsTo {
		return $this->belongsTo(Category::class, 'category_id');
	}

	public function task(): HasOne {
		return $this->hasOne(Task::class, 'task_id');
	}

	public function goal(): HasOne {
		return $this->hasOne(Goal::class, 'goal_id');
	}
}
