<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'priority_id',
        'name',
        'company',
        'estimated_budget',
        'description',
        'status',
        'started_at',
        'ended_at'
    ];

    protected $hidden = [
        'user_id',
        'category_id',
        'priority_id'
    ];    

    protected $appends = [
        'duration'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function employees() {
        return $this->belongsToMany(Employee::class, 'project_employees', 'project_id', 'employee_id');
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Calculate project duration
     * 
     * @param   datetime    $started_at
     * @param   datetime    $ended_at
     * 
     * @return  string  duration
     */
    public function getDurationAttribute() {
        if (!empty(Carbon::parse($this->started_at)) && !empty(Carbon::parse($this->ended_at))) {
            return Carbon::parse($this->ended_at)->diffInDays(Carbon::parse($this->started_at));
        }
    }

    public function getCreatedAtAttribute($date) {
        return Carbon::parse($date)->format('Y-m-d');
    }

    public function getUpdatedAtAttribute($date) {
        return Carbon::parse($date)->format('Y-m-d');
    }

    public function getStartedAtAttribute($date) {
        return Carbon::parse($date)->format('Y-m-d');
    }

    public function getEndedAtAttribute($date) {
        return Carbon::parse($date)->format('Y-m-d');
    }
}
