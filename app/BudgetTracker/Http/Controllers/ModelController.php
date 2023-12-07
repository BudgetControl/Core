<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BudgetTracker\Interfaces\ControllerResourcesInterface;
use App\BudgetTracker\Models\Models;
use App\BudgetTracker\Services\IncomingService;
use App\BudgetTracker\Services\ModelService;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\Services\ResponseService;
use Exception;
use Throwable;

class ModelController extends Controller
{
	//
	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function index(): \Illuminate\Http\JsonResponse
	{
		$cat = Models::withRelations()->get();
		return response()->json($cat);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request): \Illuminate\Http\Response
	{	
		try {
			$service = new ModelService();
			$service->save($request->toArray());
			
			return response('success');
		} catch (Throwable $e) {
			throw new Exception($e->getMessage(), 500);
		}

	}

	public function update(Request $request, int|string $id): \Illuminate\Http\Response
	{	
		try {
			$service = new ModelService($id);
			$service->save($request->toArray());
			
			return response('success');
		} catch (Throwable $e) {
			throw new Exception($e->getMessage(), 500);
		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param string $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(string $id): \Illuminate\Http\JsonResponse
	{
		$model = Models::with("label")->where("uuid",$id)->first();
		return response()->json($model);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(int $id): \Illuminate\Http\Response
	{
		return response('nothing');
	}
}
