<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factory;
use Auth;
use PharIo\Manifest\Type;
use App\Users;
use App\Models\Bkpi;
use App\Models\Fkpi;
use App\Models\Skpi;
use App\Models\Gkpi;
use App\Models\Ckpi;
use App\Models\Qkpi;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // Check if the user is Active or not
      if(Auth::user()->isActive){
        // Check if the user is of type admin or apache_note
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'superadmin'){

          return view('admin.admin');

        } else {
          // Get the factory of the logged in user

          $factory = Factory::find(Auth::user()->factory_id);
          // now check if the factory is enabled of disbaled by the super admin

          if($factory->isActive){
            // Check for the Job Type of the user
            if(Auth::user()->job == 'cutting'){
              $exists = DB::table('ckpis')->where('factory_id', Auth::user()->factory_id)->first();
              if($exists){
              $reports = Ckpi::where('factory_id', Auth::user()->factory_id)
                               ->orderBy('created_at', 'DESC')
                               ->take(30)->get(['created_at']);
                    if($reports[0]->created_at->isToday()){
                    $today = false;
                    } else {
                        $today = true;
                    }
              }
              else {
                $today = true;
              }

              // return response()->json($reports);
              return view('factory.cutting', ['today' => $today]);

            } elseif (Auth::user()->job == 'sewing') {

              $exists = DB::table('skpis')->where('factory_id', Auth::user()->factory_id)->first();
              if($exists){
              $reports = Skpi::where('factory_id', Auth::user()->factory_id)
                               ->orderBy('created_at', 'DESC')
                               ->take(30)->get(['created_at']);
                    if($reports[0]->created_at->isToday()){
                    $today = false;
                    } else {
                        $today = true;
                    }
              }
              else {
                $today = true;
              }

              // return response()->json($today);
              return view('factory.sewing', ['today'=> $today]);


            } elseif (Auth::user()->job == 'finishing') {

              $exists = DB::table('fkpis')->where('factory_id', Auth::user()->factory_id)->first();
              if($exists){
              $reports = Fkpi::where('factory_id', Auth::user()->factory_id)
                               ->orderBy('created_at', 'DESC')
                               ->take(30)->get(['created_at']);
                    if($reports[0]->created_at->isToday()){
                    $today = false;
                    } else {
                        $today = true;
                    }
              }
              else {
                $today = true;
              }

               //return response()->json($reports);
              return view('factory.finishing', ['today'=> $today]);

            } elseif (Auth::user()->job == 'quality') {

              $exists = DB::table('qkpis')->where('factory_id', Auth::user()->factory_id)->first();
              if($exists){
              $reports = Qkpi::where('factory_id', Auth::user()->factory_id)
                               ->orderBy('created_at', 'DESC')
                               ->take(30)->get(['created_at']);
                    if($reports[0]->created_at->isToday()){
                    $today = false;
                    } else {
                        $today = true;
                    }
              }
              else {
                $today = true;
              }

              // return response()->json($reports);
              return view('factory.quality', ['today'=> $today]);

            } elseif (Auth::user()->job == 'general') {

              $exists = DB::table('gkpis')->where('factory_id', Auth::user()->factory_id)->first();
              if($exists){
              $reports = Gkpi::where('factory_id', Auth::user()->factory_id)
                               ->orderBy('created_at', 'DESC')
                               ->take(30)->get(['created_at']);
                    if($reports[0]->created_at->isToday()){
                    $today = false;
                    } else {
                        $today = true;
                    }
              }
              else {
                $today = true;
              }

              //return response()->json($mmr);
              return view('factory.general', ['today'=> $today]);

            } elseif (Auth::user()->job == 'master') {

              return redirect('/admin/factory/master/'. Auth::user()->factory_id);
              // return view('factory.cutting');

            } else{

              return view('service.noservice');

            }

          }else {

            return view('service.noauth');

          }
        }

      } else {

          return view('service.noauth');
      }
    }
}
