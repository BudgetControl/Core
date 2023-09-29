<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BudgetTracker\Interfaces\ControllerResourcesInterface;
use App\BudgetTracker\Models\Incoming;
use App\BudgetTracker\Models\Payee;
use App\BudgetTracker\Services\IncomingService;
use App\BudgetTracker\Services\PayeeService;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\Services\ResponseService;

class PayeeController extends Controller implements ControllerResourcesInterface
{

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $payes = Payee::User()->with('entry')->get();
        return response()->json($payes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response
    {
        $service = new PayeeService();
        $service->save($request->toArray());
        return response('Payee data stored');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $service = new PayeeService();
        $payee = $service->read($id);
        return response()->json(new ResponseService($payee));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        $payee = Payee::findOrFail($id);
        $payee->delete();
        return response('Payee deleted');
    }
}
