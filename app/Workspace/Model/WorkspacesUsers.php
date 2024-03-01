<?php

namespace App\Workspace\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkspacesUsers extends Model
{
    use HasFactory;
    protected $table = 'workspaces_users';

    public $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
      ];
}
