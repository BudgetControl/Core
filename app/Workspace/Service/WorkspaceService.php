<?php

namespace App\Workspace\Service;

use App\BudgetTracker\Entity\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\User\Models\Entity\SettingValues;
use App\User\Models\User;
use App\User\Services\UserService;
use App\Workspace\Entity\Workspace;
use App\Workspace\Exceptions\WorkspaceException;
use App\Workspace\Model\Workspace as ModelWorkspace;

/**
 * 
 * 
 */

class WorkspaceService
{
    private Workspace $workspace;

    public function __construct(string $ID)
    {
        $this->workspace = Cache::create($ID)->get();
    }

    public static function get(int $id) : Workspace 
    {
        $ws = ModelWorkspace::find($id);
        $service = new WorkspaceService($ws->uuid);
        return $service->getWorkspace();
    }

    /**
     * create workspace
     * when user create a new Workspaces he must create a Wallet and setup the default user settings
     */
    public static function createNewWorkspace(string $name, int $userId): Workspace
    {
        // 1) create workspace
        Log::info("Set up default workspace");
        $workspace = new ModelWorkspace();
        $workspace->name = $name;
        $workspace->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $workspace->save();
        $workspace->users()->attach(User::find($userId));

        $wsId = $workspace->id;

        if(empty($wsId)) {
            throw new WorkspaceException("No Workspace found", 500);
        }

        // 2) create new wallet
        $uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $dateTIme = date("Y-m-d H:i:s", time());
        Log::info("Create new Account entry");
        DB::statement('
            INSERT INTO accounts
            (uuid,date_time,name,color,type,balance,installementValue,currency,exclude_from_stats,workspace_id)
            VALUES
            ("' . $uuid . '","' . $dateTIme . '","Cash","#C6C6C6","Cash",0,0,"EUR",0,'.$wsId.')
        ');

        // 3) setup default settings
        Log::info("Set up default settings");
        $configurations = SettingValues::Configurations->value;
        DB::statement('
            INSERT INTO user_settings
            (setting,data,workspace_id)
            VALUES
            ("'.$configurations.'","{\"currency_id\":1,\"payment_type_id\":1}",'.$wsId.')
        ');

        return new Workspace(
            $workspace, User::find($userId)
        );
    }

    /**
     * retrive WS informations
     */
    public function getWorkspace(): Workspace
    {
        return $this->workspace;
    }

    /**
     * get last used workspace by user ID
     */
    public static function getLastWorkspace(int $userID): Workspace
    {
        $ws = Db::select("
        SELECT workspaces.id as wsid FROM budgetV2.workspaces
        inner join workspaces_users as ws on ws.workspace_id = workspaces.id
        left join users on ws.workspace_id = users.id
        where workspace_id = $userID
        order by workspaces.updated_at desc;
        ;
        ");

        if(empty($ws)) {
            throw new WorkspaceException("No workspace found", 404);
        }

        $ws = $ws[0];

        return new Workspace(
            ModelWorkspace::find($ws->wsid),
            User::find($userID)
        );
    }

    /**
     * get list of workspaces
     */
    public static function getWorkspacesList(): array
    {
        $userID = UserService::getCacheUserID();
        
        $ws = Db::select("
        SELECT w.uuid, w.name, w.updated_at FROM budgetV2.workspaces as w
        inner join workspaces_users as ws on ws.workspace_id = w.id
        where ws.user_id = $userID and w.deleted_at is null
        order by w.updated_at desc;
        ");

        return $ws;
    }
}
