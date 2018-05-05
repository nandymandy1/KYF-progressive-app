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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OutputController extends Controller
{
      // Factory Controller to return all the list of factories to the register page
      public function fetchFactory(Request $req) {

      $factory = Factory::all('name', 'id');

       return response()->json($factory);

      }

      public function factoryDashboard($req){

        if(isset(Auth::user()->id)){
            return view('admin.dashboard', ['req' => $req]);
        }
        else {
            return redirect('/login');
        }

      }

      public function master($req){
        // to fetch all the cutting reports from the datatabse for the admin view

        $factory = Factory::where('id',$req)->get(['name', 'id']);

        $reports['cutting'] = Ckpi::where('factory_id', $req)->orderBy('created_at', 'DESC')->take(10)->get();
        $reports['sewing'] = Skpi::where('factory_id', $req)->orderBy('created_at', 'DESC')->take(10)->get();

        // Monthly Production Report
        /*
        QUERY FOR MYSQL ONLY
        $production = DB::table('skpis')->where('factory_id', $req)
        ->select(DB::raw('SUM(prod) as t_prod, MONTH(created_at) as month, YEAR(created_at) as year'))
        ->groupBy(DB::raw('YEAR(created_at) ASC, MONTH(created_at) ASC'))
        ->get();
        */
        // QUERY FOR SQLITE DATABASE ONLY
        $production = DB::table('skpis')
                    ->where('factory_id', $req)
                    ->select(DB::raw("SUM(prod) as tprod, strftime('%m',created_at) as month, strftime('%Y', created_at) as year"))
                    ->groupBy(DB::raw("strftime('%Y', created_at), strftime('%m',created_at)", "ASC" ))
                    ->take(12)
                    ->get();

        $reports['finishing'] = Fkpi::where('factory_id', $req)->orderBy('created_at', 'DESC')->take(10)->get();

        $reports['quality'] = Qkpi::where('factory_id', $req)->orderBy('created_at', 'DESC')->take(10)->get();

        $reports['d_general'] = Gkpi::where('factory_id', $req)->orderBy('created_at', 'DESC')->take(10)->get();

        return response()->json([ 'factory' => $factory, 'reports' => $reports, 'production' => $production]);
      }


}
