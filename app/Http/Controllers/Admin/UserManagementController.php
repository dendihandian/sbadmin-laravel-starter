<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserManagementRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends AdminBaseController
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        parent::__construct();

        $this->userModel = $userModel;
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
        $this->userModel->create($request->only($this->userModel->getFillable()));
        $request->session()->flash('success', __('User Created'));
        return redirect()->back();
    }

    public function show(int $userId)
    {
        $user = $this->userModel->find($userId);
        return view('admin.users.show', compact('user'));
    }

    public function edit(int $userId)
    {
        $user = $this->userModel->find($userId);
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserManagementRequest $request, int $userId)
    {
        $user =$this->userModel->find($userId);
        $user->update($request->only($this->userModel->getFillable()));

        // $user->detachRoles();
        // if ($request->has('role') && (int) $request->get('role')) {
        //     $user->attachRole((int) $request->get('role'));
        // }

        $request->session()->flash('success', __('User Updated'));
        return redirect()->back();
    }

    public function delete(Request $request, int $userId)
    {
        $this->userModel->where('id', $userId)->delete();
        $request->session()->flash('success', __('User Deleted'));
        return redirect()->route('admin.users.index');
    }

    public function datatable()
    {
        $users = User::all();
        return Datatables::of($users)
            ->editColumn('created_at', function($user){
                return $user->created_at->format(config('sbadmin.utilities.date_format.php'));
            })
            ->addColumn('action', function($user){
                return view('admin.users._partials.table-action', ['user' => $user]);
            })
            ->make(true);
    }
}