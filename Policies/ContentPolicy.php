<?php

namespace Modules\PageBuilder\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\PageBuilder\Enum\ContentPermission;
use Modules\PageBuilder\Models\Content;

class ContentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->canAny([ContentPermission::ViewAny->value, ContentPermission::ViewOwned->value]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Content $content): bool
    {
        if ($content->isOwnedBy($user)) {
            return true;
        }

        return $user->can(ContentPermission::View->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(ContentPermission::Create->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Content $content): bool
    {
        if ($content->isOwnedBy($user)) {
            return true;
        }

        return $user->can(ContentPermission::Update->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Content $content): bool
    {
        if ($content->isOwnedBy($user)) {
            return true;
        }

        return $user->can(ContentPermission::Delete->value);
    }

    public function replicate(User $user, Content $content): bool
    {
        if ($content->isOwnedBy($user)) {
            return true;
        }

        return $user->can(ContentPermission::Replicate->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Content $content): bool
    {
        if ($content->isOwnedBy($user)) {
            return true;
        }

        return $user->can(ContentPermission::Restore->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Content $content): bool
    {
        if ($content->isOwnedBy($user)) {
            return true;
        }

        return $user->can(ContentPermission::Delete->value);
    }





}
