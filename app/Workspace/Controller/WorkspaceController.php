<?php
namespace App\Workspace\Controller;

use App\User\Services\UserService;
use App\Workspace\Model\Workspace;
use App\Workspace\Service\WorkspaceService;
use Illuminate\Http\Request;
use Throwable;

/**
 * 
 */

class WorkspaceController {

    /**
     * retrive workspace information
     */
    public function list(): \Illuminate\Http\JsonResponse
    {
        $service = WorkspaceService::getWorkspacesList();
        return response()->json($service);
    }

    /**
     * save new workspace
     */
    public function add(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $wsName = $request->wsname;
            WorkspaceService::createNewWorkspace($wsName, UserService::getCacheUserID());
        }catch(Throwable $e){
            return response()->json(["error" => $e->getMessage()],500);
        }

        return response()->json([],201);
    }

    /**
     * update workspace
     */
    public function update(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        try {
            Workspace::find($id)->update(
                $request->toArray()
            );
        }catch(Throwable $e){
            return response()->json(["error" => $e->getMessage()],500);
        }

        return response()->json([],201);
    }
}