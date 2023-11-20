<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Entity\Label as EntityLabel;
use App\BudgetTracker\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BudgetTracker\Interfaces\ControllerResourcesInterface;
use App\BudgetTracker\Models\Labels;
use App\BudgetTracker\Services\LabelService;

class LabelController extends Controller
{
	//
	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function index(int $archive = 0): \Illuminate\Http\JsonResponse
	{
		$data = LabelService::select();
		$labels = $data->archived($archive)->order('name')->get();

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
		$data->save(
			new EntityLabel(
				$request->name,
				$request->color,
				$request->archive
			)
		);

		return response('ok');
	}

		/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public static function update(int $id, Request $request): \Illuminate\Http\Response
	{
		LabelService::find($id)->update(
			new EntityLabel(
				$request->name,
				$request->color,
				$request->archive
			)
		);

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
		$labels = LabelService::find($id)->get();
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
