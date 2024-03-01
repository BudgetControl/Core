<?php

namespace App\Workspace\Model;

use App\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workspace extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "workspaces";

    protected $fillable = [
        'updated_at'
    ];

     /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'workspaces_users','workspace_id','workspace_id');
    }


}
