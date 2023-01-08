<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class KanbanColumn extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title'];

    /**
     * Returns kanban cards that belong to this column
     * @return HasMany
     */
    public function kanban_cards(): HasMany
    {
        return $this->hasMany(KanbanCard::class, 'column_id');
    }
}
