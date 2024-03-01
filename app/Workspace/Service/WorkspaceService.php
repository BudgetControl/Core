<?php

namespace App\Workspace\Service;

use App\BudgetTracker\Entity\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\User\Models\Entity\SettingValues;
use App\User\Models\User;
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
    public static function createNewWorkspace(string $name, int $userId): int
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

        return $wsId;
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
        $ws = ModelWorkspace::with('users')->where('users.id', $userID)->orderBy('updated_at', 'desc')->first();

        return new Workspace(
            $ws,
            User::find($userID)
        );
    }
}
