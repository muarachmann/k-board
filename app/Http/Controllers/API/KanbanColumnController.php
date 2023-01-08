<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\KanbanCardRequest;
use App\Http\Requests\KanbanColumnRequest;
use App\Models\KanbanCard;
use App\Models\KanbanColumn;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Spatie\DbDumper\Databases\MySql as MySqlDumper;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class KanbanColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $kanbanColumns = KanbanColumn::all()->transform(function ($column) {
            return [
                'id' => $column->id,
                'title' => $column->title,
                'cards' => $column->kanban_cards,
            ];
        });
        return response($kanbanColumns);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param KanbanColumnRequest $request
     * @return Response
     */
    public function store(KanbanColumnRequest $request): Response
    {
        KanbanColumn::create($request->validated());
        return response(['message' => 'Successfully created Kanban Column']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        $column = KanbanColumn::withTrashed()->find($id);
        if (!$column) {
            return response(['message' => 'No such column found.'], 400);
        }
        $column->delete();
        return response(['message' => 'Successfully deleted column']);
    }

    /**
     * Get all cards in the board
     * @param Request $request
     * @return JsonResponse
     */
    public function getCards(Request $request): JsonResponse
    {
        $status = $request->status;
        $date = $request->date('date', 'Y-m-d');
        $data = KanbanCard::when(true, function ($query) use ($status) {
                switch ($status) {
                    case "1":
                        $query->withoutTrashed();
                        break;
                    case "0":
                        $query->onlyTrashed();
                        break;
                    default:
                        $query->withTrashed();
                }
            })
            ->when($date, function($query) use ($date) {
                $query->whereDate('created_at', $date);
            })
            ->get()
            ->transform(function ($card) {
                return [
                    'id' => $card->id,
                    'title' => $card->title,
                    'description' => $card->description,
                    'deleted_at' => $card->deleted_at ? $card->deleted_at->format('Y-m-d H:i:s') : null
                ];
            });
        return response()->json($data);
    }

    /**
     * Add column to card
     * @param KanbanCardRequest $request
     * @param string $column_id
     * @return Application|Response|ResponseFactory
     */
    public function addCard(KanbanCardRequest $request, string $column_id): Response|Application|ResponseFactory
    {
        $column = KanbanColumn::find($column_id);
        if (!$column) {
            return response(['message' => 'No such column found.'], 400);
        }
        $card = KanbanCard::updateOrCreate(
            ['id' => $request->id],
            [
                'column_id' => $column->id,
                'title' => $request->title,
                'description' => $request->description
            ]);
        return response([
            'card' => [
                'id' => $card->id,
                'title' => $card->title,
                'description' => $card->description
            ],
            'message' => $card->wasRecentlyCreated ?
                "Successfully added card to $column->title" :
                "Successfully updated card on $column->title"
        ]);
    }


    /**
     * Download sheet for all users and stats
     * @param Request $request
     * @return Application|ResponseFactory|Response|BinaryFileResponse
     */
    public function downloadBoard(Request $request): Response|BinaryFileResponse|Application|ResponseFactory
    {
        MySqlDumper::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->dumpToFile(Storage::path('public/kanban_board.sql'));

        $filePath = Storage::path('public/kanban_board.sql');
        $fileName = 'kanban_board.sql';
        $mimeType = Storage::mimeType($filePath);
        $headers = [['Content-Type' => $mimeType]];
        return response()->download($filePath, $fileName, $headers);
    }
}
