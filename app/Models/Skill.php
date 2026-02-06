<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    protected $table = 'skills';

    protected $fillable = [
        'name',
    ];

    public function candidateCvs(): BelongsToMany
    {
        return $this->belongsToMany(CandidateCv::class, 'candidate_cv_skill')
            ->withTimestamps();
    }
}
