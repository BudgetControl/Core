<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\User\Models\User;
use App\User\Models\UserSettings;
use App\Workspace\Service\WorkspaceService;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();;
        $user->name = "foo bar";
        $user->password = bcrypt("password");
        $user->email = "foo@email.it";
        $user->email_verified_at = date("Y-m-d H:i:s");
        $user->save();

        WorkspaceService::createNewWorkspace('test', $user->id)->saveInCache()->saveInCacheFromSession();
    }
}
