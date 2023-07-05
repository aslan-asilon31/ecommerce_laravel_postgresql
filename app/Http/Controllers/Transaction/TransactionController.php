<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction\Transaction;
// use App\Swagger\Schemas\Transaction;


/**
 * @OA\Get(
 *    path="/api/transaction",
 *    summary="Get all Transactions",
 *    description="Retrieve a list of all Transactions",
 *    tags={"Transaction"},
 *    @OA\Response(
 *      response=200,
 *      description="Successful operation",
 *    ),
 *    security={{"bearerAuth": {}}}
 * ),
**/

class TransactionController extends Controller
{
    public function index(){
        $transactions = Transaction::all();
        return $transactions;
    }
}
