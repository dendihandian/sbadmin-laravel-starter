<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\YouCannotDeleteYourself;
use App\Http\Requests\UserManagementRequest;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();

        View::share('role_options', Role::all()->keyBy('name')->transform(function($role){
            return $role->display_name ?? $role->name;
        })); // TODO: better if cached
    }

    public function index()
    {
        return view('admin.users.index');
    }

    public function create()
    {
        return view('admin.users.create');
    }
    
    public function store(UserManagementRequest $request)
    {
        $user = User::create($request->only(User::FILLABLE_FIELDS));

        if ($request->role ?? false) $user->syncRoles([$request->role]);

        $request->session()->flash('success', __('User Created'));
        return redirect()->back();
    }

    public function show(Request $request)
    {
        $user = $request->_user;
        return view('admin.users.show', compact('user'));
    }

    public function edit(Request $request)
    {
        $user = $request->_user;
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserManagementRequest $request, int $userId)
    {
        $user = $request->_user;
        $user->update($request->only(User::FILLABLE_FIELDS));

        if ($request->role ?? false) $user->syncRoles([$request->role]);

        $request->session()->flash('success', __('User Updated'));
        return redirect()->back();
    }

    public function delete(Request $request, int $userId)
    {
        $user = $request->_user;
        if ($request->user()->id === (int) $user->id) {
            throw new YouCannotDeleteYourself();
        };

        $user->delete();
        $request->session()->flash('success', __('User Deleted'));
        return redirect()->route('admin.users.index');
    }

    public function datatable()
    {
        $users = User::with('roles')->get();
        return Datatables::of($users)
            ->editColumn('created_at', function($user){
                return $user->created_at->format(config('sbadmin.utilities.date_format.php'));
            })
            ->addColumn('role', function($user){
                return $user->roles[0]->display_name ?? $user->roles[0]->display_name ?? '-';
            })
            ->addColumn('action', function($user){
                return view('admin.users._partials.table-action', ['user' => $user]);
            })
            ->make(true);
    }
}
