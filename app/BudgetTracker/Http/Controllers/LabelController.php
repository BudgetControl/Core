<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BudgetTracker\Interfaces\ControllerResourcesInterface;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\Services\ResponseService;
use App\BudgetTracker\Models\Labels;
use App\BudgetTracker\Services\LabelService;
use PhpParser\Node\Stmt\Label;

class LabelController extends Controller implements ControllerResourcesInterface
{
	//
	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function index(): \Illuminate\Http\JsonResponse
	{
		$data = new LabelService();
		$labels = $data->order('name')->get();

		return response()->json($labels->toArray());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request): \Illuminate\Http\Response
	{
		$data = LabelService::create();
		$data->save([
			'name' => $request->name,
			'color' => $request->color,
			'archive' => $request->archive
		]);

		return response('ok');
	}

		/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(int $id, Request $request): \Illuminate\Http\Response
	{
		$data = new LabelService(LabelService::SELECT);
		$data->save([
			'name' => $request->name,
			'color' => $request->color,
			'archive' => $request->archive
		]);

		return response('ok');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(int $id): \Illuminate\Http\JsonResponse
	{
		$data = new LabelService(LabelService::SELECT);
		$data->read($id);
		$labels = $data->get();

		return response()->json($labels->toArray());
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
