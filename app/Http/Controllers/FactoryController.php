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
class FactoryController extends Controller
{
    public function cutting(){

      return view('factory.cutting');
    }
    public function sewing(){

      return view('factory.sewing');

    }
    public function finishing(){

      return view('factory.finishing');

    }
    public function quality(){

      return view('factory.quality');

    }
    public function general(){

      return view('factory.general');

    }


    public function cut($id){
      $reports = Ckpi::where('factory_id', $id)
                       ->orderBy('created_at', 'DESC')
                       ->take(30)->get();
      return response()->json($reports);
    }

    public function sew($id){

      $reports = Skpi::where('factory_id', $id)
                       ->orderBy('created_at', 'DESC')
                       ->take(30)->get();

      $prod = DB::table('skpis')
                  ->where('factory_id', $id)
                  ->select(DB::raw("SUM(prod) as tprod, strftime('%m',created_at) as month, strftime('%Y', created_at) as year"))
                  ->groupBy(DB::raw("strftime('%Y', created_at), strftime('%m',created_at)", "ASC" ))
                  ->take(12)
                  ->get();

      return response()->json(['reports' => $reports, 'prod' => $prod]);
    }

    public function fin($id){
      $reports = Fkpi::where('factory_id', $id)
                       ->orderBy('created_at', 'DESC')
                       ->take(30)->get();
      return response()->json($reports);
    }

    public function qua($id){
      $reports = Qkpi::where('factory_id', $id)
                       ->orderBy('created_at', 'DESC')
                       ->take(30)->get();
      return response()->json($reports);
    }

    public function gen($id){

      $reports = Gkpi::where('factory_id', $id)
                       ->orderBy('created_at', 'DESC')
                       ->take(30)->get();

      $mmr = Skpi::where('factory_id', $id)
                                       ->orderBy('created_at', 'DESC')
                                       ->take(30)
                                       ->get(['sopr', 'kopr','created_at']);
      return response()->json(['reports'=> $reports, 'mmr'=> $mmr]);

    }

    public function test($id){

      $prod = DB::table('skpis')
                  ->where('factory_id', $id)
                  ->select(DB::raw("SUM(prod) as tprod, strftime('%m',created_at) as month, strftime('%Y', created_at) as year"))
                  ->groupBy(DB::raw("strftime('%Y', created_at), strftime('%m',created_at)", "ASC" ))
                  ->take(12)
                  ->get();

      return response()->json($prod);
    }

}
