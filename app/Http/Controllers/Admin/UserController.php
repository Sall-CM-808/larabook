<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $adminId = $request->user()->getAdminId();
        $search = $request->get('search');

        $query = User::where('admin_id', $adminId)->with('roles');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('name')->paginate(20);

        return view('admin.users.index', compact('users', 'search'));
    }

    public function create()
    {
        $roles = Role::whereIn('slug', ['bibliothecaire', 'etudiant'])->orderBy('nom')->get();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'matricule' => 'required|string|unique:users,matricule',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ]);

        $adminId = $request->user()->getAdminId();

        $allowedRoles = Role::whereIn('slug', ['bibliothecaire', 'etudiant'])->pluck('id')->toArray();
        $requestedRoles = array_intersect($request->roles, $allowedRoles);

        if (empty($requestedRoles)) {
            return back()->withErrors(['roles' => 'Vous devez sélectionner au moins un rôle valide.'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'matricule' => $request->matricule,
            'password' => Hash::make($request->password),
            'admin_id' => $adminId,
        ]);

        $user->roles()->sync($requestedRoles);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(Request $request, User $user)
    {
        $adminId = $request->user()->getAdminId();

        if ($user->admin_id !== $adminId) {
            abort(403);
        }

        $roles = Role::whereIn('slug', ['bibliothecaire', 'etudiant'])->orderBy('nom')->get();
        $user->load('roles');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $adminId = $request->user()->getAdminId();

        if ($user->admin_id !== $adminId) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'matricule' => 'required|string|unique:users,matricule,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ]);

        $allowedRoles = Role::whereIn('slug', ['bibliothecaire', 'etudiant'])->pluck('id')->toArray();
        $requestedRoles = array_intersect($request->roles, $allowedRoles);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'matricule' => $request->matricule,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->roles()->sync($requestedRoles);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(Request $request, User $user)
    {
        $adminId = $request->user()->getAdminId();

        if ($user->admin_id !== $adminId) {
            abort(403);
        }

        $activeLoans = $user->loans()->whereIn('statut', ['en_cours', 'en_retard'])->count();

        if ($activeLoans > 0) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Impossible de supprimer un utilisateur avec des emprunts actifs.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}
