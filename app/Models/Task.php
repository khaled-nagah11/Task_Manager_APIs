<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_done',
        'project_id',
        'creator_id'
    ];
    protected $casts = [
        'is_done'=> 'boolean',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class , 'project_id');
    }

    protected static function booted()
    {
        static::addGlobalScope('member', function (Builder $builder) {
           $builder->where('creator_id', Auth::id())
           ->orWhereIn('project_id' , Auth::user()->memberships->pluck('id'));
        });
    }

}
