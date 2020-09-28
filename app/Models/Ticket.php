<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'user_id',
        'project_id',        
        'subject',
        'description',
        'file',
        'status',
        'response',
        'started_at',
        'ended_at'
    ];

    protected $hidden = [
        'user_id',
        'project_id'
    ];

    protected $appends = [
        'duration',
        'fileUrl',
        'remainingTime'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function getDurationAttribute() {
        $start = Carbon::parse($this->started_at);
        $end = Carbon::parse($this->ended_at);
        if (!empty($start) && !empty($end)) {
            return Carbon::parse($end)->diffInDays(Carbon::parse($start));
        }
    }

    public function getFileUrlAttribute() {
        if($this->file) {
            return Storage::url('uploads/' . $this->file);
        } else {
            return null;
        }
    }

    public function getRemainingTimeAttribute() {
        $now = Carbon::now();
        $end = Carbon::parse($this->ended_at);
        if(!empty($end)) {
            return Carbon::parse($now)->diffInDays(Carbon::parse($end));
        }
    }

    public function getCreatedAtAttribute($date) {
        return Carbon::parse($date)->format('Y-m-d');
    }
}
