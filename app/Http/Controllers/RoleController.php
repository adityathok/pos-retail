<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\RolePermissionService;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RolePermissionService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display roles management page (Owner only)
     */
    public function index()
    {
        // Check if user has Owner role
        if (!auth()->user()->hasRole('Owner')) {
            abort(403, 'Hanya Owner yang dapat mengakses halaman ini.');
        }

        $roles = $this->roleService->getAllRoles();
        $users = User::with('roles')->get();

        return Inertia::render('Admin/Roles', [
            'roles' => $roles,
            'users' => $users
        ]);
    }

    /**
     * Assign role to user
     */
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_name' => 'required|string|exists:roles,name'
        ]);

        $user = User::findOrFail($request->user_id);
        $success = $this->roleService->assignRole($user, $request->role_name);

        if ($success) {
            return back()->with('success', 'Role berhasil diberikan kepada user.');
        }

        return back()->with('error', 'Gagal memberikan role kepada user.');
    }

    /**
     * Remove role from user
     */
    public function removeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_name' => 'required|string|exists:roles,name'
        ]);

        $user = User::findOrFail($request->user_id);
        $success = $this->roleService->removeRole($user, $request->role_name);

        if ($success) {
            return back()->with('success', 'Role berhasil dihapus dari user.');
        }

        return back()->with('error', 'Gagal menghapus role dari user.');
    }

    /**
     * Dashboard for different roles
     */
    public function dashboard()
    {
        $user = auth()->user();
        $userRoles = $user->roles->pluck('name')->toArray();

        // Different dashboard based on role
        if ($user->hasRole('Owner')) {
            return Inertia::render('Dashboard/Owner');
        } elseif ($user->hasRole('Manajer')) {
            return Inertia::render('Dashboard/Manager');
        } elseif ($user->hasRole('Kasir')) {
            return Inertia::render('Dashboard/Cashier');
        } elseif ($user->hasRole('Admin Akuntansi')) {
            return Inertia::render('Dashboard/Accounting');
        } elseif ($user->hasRole('Staf Gudang')) {
            return Inertia::render('Dashboard/Warehouse');
        } elseif ($user->hasRole('Pegawai')) {
            return Inertia::render('Dashboard/Employee');
        }

        return Inertia::render('Dashboard/Default', [
            'userRoles' => $userRoles
        ]);
    }

    /**
     * Get users by role (for API)
     */
    public function getUsersByRole(Request $request)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name'
        ]);

        $users = $this->roleService->getUsersByRole($request->role);

        return response()->json([
            'users' => $users,
            'role' => $request->role
        ]);
    }
}
