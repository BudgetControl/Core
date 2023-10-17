<?php

namespace App\BudgetTracker\Http\Controllers;

use Illuminate\Http\Request;
use App\User\Services\UserService;
use App\BudgetTracker\Models\Category;
use App\BudgetTracker\Services\IncomingService;
use App\BudgetTracker\Services\ResponseService;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\Http\Controllers\Controller;
use App\BudgetTracker\Interfaces\ControllerResourcesInterface;
use App\BudgetTracker\Services\CategoryService;

class CategoryController extends Controller implements ControllerResourcesInterface
{
	//
	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function index(): \Illuminate\Http\JsonResponse
	{
		$service = new CategoryService();
		return response()->json(new ResponseService($service->all()));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request): \Illuminate\Http\Response
	{
		$service = new CategoryService();
		$service->save($request);
		return response('ok');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, int $id): \Illuminate\Http\Response
	{
		$service = new CategoryService($id);
		$service->save($request);
		return response('nothing');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(int $id): \Illuminate\Http\JsonResponse
	{
		return response()->json([], 'nothing');
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
