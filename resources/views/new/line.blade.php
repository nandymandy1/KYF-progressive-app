@extends('layouts.app')

@section('content')
<div class="container" id="app">
<!-- Button trigger modal -->

<div class="card">
  <div class="card-header">
    Today's Lines
  </div>
  <div class="card-body">
    <table class="table">
        <thead class="thead-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Order Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Line Efficiency</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="line,key in lines">
            <td>@{{ key+1 }}</td>
            <td>@{{ line.order_id }}</td>
            <td>@{{ line.qty }}</td>
            <td>@{{ line.effi }}</td>
            </tr>
        </tbody>
    </table>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#lineModal">
        Add Line
    </button>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="lineModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Line</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="">Number Of Sewing Operators</label>
            <input type="number" name="sopr" v-model="newLine.sopr" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Number Of Kaja Operators</label>
            <input type="number" name="kopr" v-model="newLine.kopr" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Number Of Helpers</label>
            <input type="number" name="hlpr" v-model="newLine.hlpr" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Number Of Checkers</label>
            <input type="number" name="chkr" v-model="newLine.chkr" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Order</label>
            <select name="order_id" class="form-control" v-model="newLine.order_id" id="">
                <option v-for="order in orders" :value="order.id">@{{order.order_name}}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Order Quantity</label>
            <input type="number" name="qty" v-model="newLine.qty" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" @click="addLine" data-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    var app = new Vue({
        el:'#app',
        data(){
            return{
            factory_id:{{Auth::user()->factory_id}},
            lines:[],
            orders:[],
            newLine:{
                hlpr:'',
                kopr:'',
                sopr:'',
                chkr:'',
                order_id:'',
                qty:'',
                factory_id: {{Auth::user()->factory_id}}
                }
            }
        },
        methods:{
            addLine(){
                axios.post('/addline', this.$data.newLine).then(res => {
                    this.newLine.hlpr =''
                    this.newLine.kopr = ''
                    this.newLine.sopr = ''
                    this.newLine.chkr = ''
                    this.newLine.order_id = ''
                    this.newLine.qty = ''
                    this.lines.unshift(res.data);
                }).catch(err => console.log(err))
            },
            fetchLines(){
                axios.get(`get/lines/today/${this.factory_id}`).then(res=> {
                    this.lines = res.data
                }).catch(err => console.log(err))
            },
            fetchOrders(){
                axios.get(`/get/orders/${this.factory_id}`).then(res => {
                this.orders = res.data
                console.log(this.orders);
                }).catch(err => { console.log(err) })
            }
        },
        created(){
            this.fetchOrders(),
            this.fetchLines()
        }
    });
</script>
@endsection