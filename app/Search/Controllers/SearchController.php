<?php
namespace Search\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Search\Services;
use Search\Services\SearchService;

class SearchController {
    

	//
	/**
	 * Display a listing of the resource.
	 * @return JsonResponse
	 * @throws \Exception
	 */
	public function index(): JsonResponse
	{
        $month = date('m',time());
        $year = date('Y',time());

		$service = new SearchService($month,$year);
        list($incomig,$expenses,$transfer,$debit) = $service->find([]);

        return response()->json([
            'incoming' => [
                'data' => $incomig->getEntry(),
                'balance' => $incomig->getBalance()
            ],
            'expenses' => [
                'data' => $expenses->getEntry(),
                'balance' => $expenses->getBalance()
            ],
            'transfer' => [
                'data' => $transfer->getEntry(),
                'balance' => $transfer->getBalance()
            ],
            'debit' => [
                'data' => $debit->getEntry(),
                'balance' => $debit->getBalance()
            ],
        ]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request): Response
	{
			
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return JsonResponse
	 */
	public function show(int $id): JsonResponse
	{
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request): Response
	{
			
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function destroy(int $id): Response
	{
	}

}
