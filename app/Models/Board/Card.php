<?php

namespace App\Models\Board;

use App\Models\Board\Column;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory;

    public function column(): BelongsTo
    {
        return $this->belongsTo(Column::class);
    }
}
