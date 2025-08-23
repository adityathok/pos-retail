<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionService
{
    /**
     * Assign role to user
     */
    public function assignRole(User $user, string $roleName): bool
    {
        try {
            $user->assignRole($roleName);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Remove role from user
     */
    public function removeRole(User $user, string $roleName): bool
    {
        try {
            $user->removeRole($roleName);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check if user has role
     */
    public function hasRole(User $user, string $roleName): bool
    {
        return $user->hasRole($roleName);
    }

    /**
     * Get all available roles
     */
    public function getAllRoles()
    {
        return Role::all();
    }

    /**
     * Get user roles
     */
    public function getUserRoles(User $user)
    {
        return $user->roles;
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole(User $user, array $roles): bool
    {
        return $user->hasAnyRole($roles);
    }

    /**
     * Check if user has all of the given roles
     */
    public function hasAllRoles(User $user, array $roles): bool
    {
        return $user->hasAllRoles($roles);
    }

    /**
     * Get users by role
     */
    public function getUsersByRole(string $roleName)
    {
        return User::role($roleName)->get();
    }
}