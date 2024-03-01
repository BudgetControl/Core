<?php
namespace App\Workspace\Entity;

use App\BudgetTracker\Entity\Cache;
use App\BudgetTracker\Traits\Caching;
use App\User\Models\User;
use App\Workspace\Model\Workspace as ModelWorkspace;

/**
 * 
 */

 final class Workspace {

    use Caching;

    private readonly ModelWorkspace $workspace;
    private readonly User $user;
    private readonly string $hash;

    public function __construct(ModelWorkspace $ws, User $user)
    {
        $this->ttl = Cache::TTL_FOREVER;
        $ws->update(
            ['updated_at' => date('Y-m-d H:i:s', time())]
        );

        $this->workspace = $ws;
        $this->user = $user;
        $this->hash = \Ramsey\Uuid\Uuid::uuid4()->toString();
    }

    /**
     * Get the value of workspace
     *
     * @return ModelWorkspace
     */
    public function getWorkspace(): ModelWorkspace
    {
        return $this->workspace;
    }

    /**
     * Get the value of user
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Get the value of uuid
     *
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

 }