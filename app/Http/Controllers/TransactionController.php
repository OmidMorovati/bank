<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\HistoryRequest;
use App\Http\Resources\Transaction\TransactionResource;
use App\Services\TransactionService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TransactionController extends Controller
{
    public function __construct(private TransactionService $transactionService)
    {
    }

    public function history(HistoryRequest $request): AnonymousResourceCollection
    {
       return TransactionResource::collection($this->transactionService->history($request->account));
    }
}
