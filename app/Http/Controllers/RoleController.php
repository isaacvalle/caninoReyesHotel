<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$adminRole = Role::create(['name' => 'admin']);
    	$userRole = Role::create(['name' => 'user']);
        $guestRole = Role::create(['name' => 'guest']);

        $adminRole->givePermissionTo('create.users');
        $adminRole->givePermissionTo('edit.users');
        $adminRole->givePermissionTo('delete.users');
        $adminRole->givePermissionTo('getall.users');
        $adminRole->givePermissionTo('create.reservations');
        $adminRole->givePermissionTo('edit.reservations');
        $adminRole->givePermissionTo('get.reservations');
        $adminRole->givePermissionTo('getall.reservations');
        $adminRole->givePermissionTo('create.dogs');
        $adminRole->givePermissionTo('edit.dogs');
        $adminRole->givePermissionTo('delete.dogs');
        $adminRole->givePermissionTo('getall.dogs');
        $adminRole->givePermissionTo('get.dogs');
        $adminRole->givePermissionTo('create.rooms');
        $adminRole->givePermissionTo('edit.rooms');
        $adminRole->givePermissionTo('create.services');
        $adminRole->givePermissionTo('edit.services');
        $adminRole->givePermissionTo('delete.services');
        $adminRole->givePermissionTo('getall.services');
        $adminRole->givePermissionTo('get.box');
        $adminRole->givePermissionTo('edit.box');

        $userRole->givePermissionTo('create.users');
        $userRole->givePermissionTo('edit.users');
        $userRole->givePermissionTo('create.reservations');
        $userRole->givePermissionTo('edit.reservations');
        $userRole->givePermissionTo('get.reservations');
        $userRole->givePermissionTo('create.dogs');
        $userRole->givePermissionTo('edit.dogs');
        $userRole->givePermissionTo('delete.dogs');
        $userRole->givePermissionTo('get.dogs');

        $guestRole->givePermissionTo('create.reservations');
        $guestRole->givePermissionTo('edit.reservations');

    }
}
