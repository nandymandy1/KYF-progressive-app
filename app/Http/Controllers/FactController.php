<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factory;
use Illuminate\Support\Facades\Hash;
use App\User;

class FactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getFactory()
    {
        return response()->json(Factory::orderBy('id', 'ASC')->get());
    }

    public function getUsers()
    {
      $tUsers = User::where('job', 'master')->orderBy('name', 'ASC')->get();
      $factories = Factory::orderBy('id', 'ASC')->get();
      $users = [];
      foreach ($tUsers as $tUser) {
        foreach ($factories as $factory) {
          if($tUser->factory_id == $factory->id){
            $users[] = [
              'id' => $tUser->id,
              'name' => $tUser->name,
              'username' => $tUser->username,
              'email' => $tUser->email,
              'factory' => $factory->name,
              'isActive' => $tUser->isActive
            ];
          }
        }
      }
      return response()->json($users);
    }

    public function getAdmins()
    {
        $admins = User::where('type','admin')->orderBy('name', 'ASC')->get();
        return response()->json($admins);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $f = new Factory;
        $f->name = $request->input('name');
        $f->isActive = $request->input('isActive');
        $f->save();
        return $f;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function enable_disable($id)
    {
        $factory = Factory::find($id);
        // return response()->json($factory);
        if($factory->isActive == 1){
          $factory->isActive = 0;
        }
        else {
          $factory->isActive = 1;
        }
        $factory->save();

    }

    public function endisUser($id)
    {
        $user = User::find($id);
        if($user->isActive == 1){
          $user->isActive = 0;
        } else {
          $user->isActive = 1;
        }
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function del($id)
    {
        $factory = Factory::where('id', $id);
        return $factory->delete();
    }


    public function master($id){

    }

    /*
    // To create Super Admin
    public function createAdmin(){
        return User::create([
            'name' => 'Ajay Ravuri',
            'email' => 'ajay.ravuri@arvindbrands.com',
            'username' => 'ajay_ravuri',
            'password' => Hash::make('password123'),
            'factory_id' => '',
            'job' => '',
            'isActive' => 1,
            'type' => 'superadmin',
        ]);
    }
    */

    // Factory owners to maintain the users
    public function getFactoryUsers($id){
      $users = User::where('factory_id', $id)->get();
      return response()->json($users);
    }




}
