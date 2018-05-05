<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Line;
use App\Models\Ordern;
use App\Models\Style;
use App\Cut;
use App\Finish;
use App\Models\Quality;

class MerchantController extends Controller
{
    //
    public function addStyles(Request $req){
        // dd($req);
        $style = new Style;
        $style->styles_name = $req->input('style_name');
        $style->brand_name = $req->input('brand_name');
        $style->factory_id = $req->input('factory_id');
        $style->save();
        return response()->json($style);
    }
    // fetch all the styles from the database
    public function getStyles($factory_id){
        $styles = Style::where('factory_id', $factory_id)->orderBy('id', 'DESC')->get();
        return response()->json($styles);
    }
    // Delete Any Style
    public function delStyles($id){ 
        $style = Style::find($id);
        $style->delete();
        return  response()->json(['success' => true]);
    }
    // Add Orders 
    public function addOrders(Request $req){
        $order = new Ordern;
        $order->factory_id = $req->input('factory_id');
        $order->order_name = $req->input('order_name');
        $order->style_name = $req->input('style_name');
        $order->qty = $req->input('qty');
        $order->sam = $req->input('sam');
        $order->delivery_date = $req->input('delivery_date');
        $order->save();
        return response()->json($order);
    }
    // fetch all the Orders from the database
    public function getOrders($factory_id){
        $orders = Ordern::where('factory_id', $factory_id)->orderBy('id', 'DESC')->get();
        return response()->json($orders);
    }
    // delete Orders
    public function delOrders($id){ 
        $style = Ordern::find($id);
        $style->delete();
        return  response()->json(['success' => true]);
    }
    
    // Line Setting
    public function addLine(Request $req){
        $line = new Line;
        $sopr = intval($req->input('sopr'));
        $kopr = intval($req->input('kopr'));
        $hlpr = intval($req->input('hlpr'));
        $chkr = intval($req->input('chkr'));
        $qty = intval($req->input('qty'));
        $line->order_id = $req->input('order_id');
        // Get Sam
        $order = Ordern::find($line->order_id);
        $sam = floatval($order->sam);
        $line->sopr = $sopr;
        $line->kopr = $kopr;
        $line->helper = $hlpr;
        $line->checker = $chkr;
        $line->qty = $qty;
        $order->sqty = intval($order->sqty) + $qty;
        $line->sam = $sam;
        $line->factory_id = $req->input('factory_id');
        $line->effi = round(((($qty * $sam)/(($sopr+$kopr+$hlpr+$chkr)*480))*100), 2) ;
        $line->save();
        $order->line = $line->id;
        $order->save();
        return response()->json($line);
    }
    
    public function getLinesToday($id){
        $lines = Line::where('factory_id', $id)->where('created_at', '>=', date('Y-m-d').' 00:00:00')->orderBy('created_at', 'ASC')->get();
        return response()->json($lines);
    }
    // Save the cutting daily data orderwise
    public function saveCutting(Request $req){
        $cut = new Cut;
        $cut->order_id = $req->input('order_id');
        $cut->qty = $req->input('qty');
        $cut->factory_id = $req->input('factory_id');
        $order = Ordern::find($cut->order_id);
        $cut->save();
        $order->cqty = intval($order->cqty) + intval($cut->qty);
        $order->save();
        return response()->json($cut);
    }
    // Get all the today's Cutting plan
    public function getCutting($id){
        $cuts = Cut::where('factory_id', $id)->where('created_at', '>=', date('Y-m-d').' 00:00:00')->orderBy('created_at', 'ASC')->get();
        return response()->json($cuts);
    }
    // Add the Finishing Order
    public function addFinish(Request $req){
        $finish = new Finish;
        $finish->fqty = $req->input('fqty');
        $finish->factory_id = $req->input('factory_id');
        $finish->order_id = $req->input('order_id');
        $order = Ordern::find($finish->order_id);
        $finish->save();
        $order->fqty = intval($order->fqty) + intval($finish->fqty);
        $order->save();
        return response()->json($finish);
    }
    // Get todays all the finished Quantites
    public function getFinish($id){
        $finish = Finish::where('factory_id', $id)->where('created_at', '>=', date('Y-m-d').' 00:00:00')->orderBy('created_at', 'ASC')->get();
        return response()->json($finish);
    }
    // Add the quality data
    public function addQuality(Request $req){
        $q = new Quality;
        $qty = intval($req->input('qty'));
        $ppcs = intval($req->input('p_pcs'));
        $q->order_id = $req->input('order_id');
        $q->factory_id = $req->input('factory_id');
        $q->qty = $qty;
        $q->ppcs = $ppcs;
        $q->dhu = round(((1- ($ppcs/$qty))*100), 2);
        $q->save();
        return $q;
    }
    //get today's quality reports
    public function getQuality($id){
        $quality = Quality::where('factory_id', $id)->where('created_at', '>=', date('Y-m-d').' 00:00:00')->orderBy('created_at', 'ASC')->get();
        return response()->json($quality);
    }
    public function getOrderDetail($id){
        $quality = Quality::where('order_id', $id)->get();
        $fin  = Finish::where('order_id', $id)->get();
        $cut     = Cut::where('order_id', $id)->get();
        $sew     = Line::where('order_id', $id)->get();
        return response()->json([
            'qua'     => $quality,
            'sew'     => $sew,
            'cut'     => $cut,
            'fin'     => $fin 
            ]);
    }
    public function getOrder($id){
        $order = Ordern::find($id);
        return response()->json($order);
    }
    public function getStyleName($id){
        $style = Style::find($id);
        return response()->json($style->styles_name);
    }

}


