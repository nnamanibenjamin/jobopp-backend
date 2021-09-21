<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpportunityDetail extends Model
{
    public function opportunity(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Opportunity::class);
    }
}
