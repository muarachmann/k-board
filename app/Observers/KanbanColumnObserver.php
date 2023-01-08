<?php

namespace App\Observers;

use App\Models\KanbanColumn;

class KanbanColumnObserver
{
    /**
     * Handle the KanbanColumn "created" event.
     *
     * @param KanbanColumn $kanbanColumn
     * @return void
     */
    public function created(KanbanColumn $kanbanColumn)
    {
        //
    }

    /**
     * Handle the KanbanColumn "updated" event.
     *
     * @param KanbanColumn $kanbanColumn
     * @return void
     */
    public function updated(KanbanColumn $kanbanColumn)
    {
        //
    }

    /**
     * Handle the KanbanColumn "deleted" event.
     *
     * @param KanbanColumn $kanbanColumn
     * @return void
     */
    public function deleted(KanbanColumn $kanbanColumn): void
    {
        // delete all the cards associated to this model
        $kanbanColumn->kanban_cards()->delete();
    }

    /**
     * Handle the KanbanColumn "restored" event.
     *
     * @param KanbanColumn $kanbanColumn
     * @return void
     */
    public function restored(KanbanColumn $kanbanColumn)
    {
        //
    }

    /**
     * Handle the KanbanColumn "force deleted" event.
     *
     * @param KanbanColumn $kanbanColumn
     * @return void
     */
    public function forceDeleted(KanbanColumn $kanbanColumn)
    {
        //
    }
}
