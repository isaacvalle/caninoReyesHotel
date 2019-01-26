<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	//Permission::truncate();

	    Permission::create(['name' => 'create.users']);
	    Permission::create(['name' => 'edit.users']);
	    Permission::create(['name' => 'delete.users']);
	    Permission::create(['name' => 'getall.users']);
	    Permission::create(['name' => 'create.reservations']);
	    Permission::create(['name' => 'edit.reservations']);
	    Permission::create(['name' => 'get.reservations']);
	    Permission::create(['name' => 'getall.reservations']);
	    Permission::create(['name' => 'create.dogs']);
	    Permission::create(['name' => 'edit.dogs']);
	    Permission::create(['name' => 'delete.dogs']);
	    Permission::create(['name' => 'getall.dogs']);
	    Permission::create(['name' => 'get.dogs']);
	    Permission::create(['name' => 'create.rooms']);
	    Permission::create(['name' => 'edit.rooms']);
	    Permission::create(['name' => 'create.services']);
	    Permission::create(['name' => 'edit.services']);
	    Permission::create(['name' => 'delete.services']);
	    Permission::create(['name' => 'getall.services']);
	    Permission::create(['name' => 'get.box']);
	    Permission::create(['name' => 'edit.box']);
	}
}
