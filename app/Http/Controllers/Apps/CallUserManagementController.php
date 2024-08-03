<?php

namespace App\Http\Controllers\Apps;

use App\Models\User;
use App\Models\CallUser;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\DataTables\CallUsersDataTable;

class CallUserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index(CallUsersDataTable $dataTable)
        {
            return $dataTable->render('pages/apps.user-management.call-users.list');
        }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = CallUser::find($id);
        return view('pages/apps.user-management.call-users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
