<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class KanbanCard extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'column_id', 'description', 'priority'];

    /**
     * Returns kanban column of the card
     * @return BelongsTo
     */
    public function kanban_column(): BelongsTo
    {
        return $this->belongsTo(KanbanColumn::class, 'column_id');
    }
}
