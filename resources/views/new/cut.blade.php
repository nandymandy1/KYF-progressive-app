@extends('layouts.app')

@section('content')
<div class="container" id="app">
<!-- Button trigger modal -->

<div class="card">
  <h5 class="card-header">Today's Cutting Order</h5>
  <div class="card-body">
    <table class="table">
    <thead class="thead-dark">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Order Name</th>
        <th scope="col">Quantity</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
        <tr v-for="cut,key in cutting">
            <td>@{{ key+1 }}</td>
            <td>@{{ cut.order_id }}</td>
            <td>@{{ cut.qty }}</td>
        </tr>
    </table>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Cutting Plans</button>    
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="">Cutting Quantity</label>
            <input type="number" name="qty" v-model="newCut.qty" class="form-control">
        </div>        
        <div class="form-group">
            <label for="">Order</label>
            <select name="order_id" class="form-control" v-model="newCut.order_id">
                <option v-for="order in orders" :value="order.id">@{{order.order_name}}</option>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="addTodaysCuttingOrders">Save Order</button>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    var app = new Vue({
        el: '#app',
        data(){
            return{
                cutting:[],
                orders:[],
                order_names:[],
                factory_id:1,
                newCut:{
                    order_id:'',
                    factory_id: 1,
                    qty:''
                }
            }
        },
        methods:{
            fetchTodaysCuttingOrders(){
                axios.get(`/get/cutting/order/${this.factory_id}`).then(res =>{
                 this.cutting = res.data
                 console.log(this.cutting)   
                }).catch(err => console.log(err))
            },
            addTodaysCuttingOrders(){
                axios.post('/add/cutting/order', this.$data.newCut).then(res => this.cutting.unshift(res.data)).catch(err => console.log(err))
            },
            fetchOrders(){
                axios.get(`/get/orders/${this.factory_id}`).then(res => {
                this.orders = res.data
                }).catch(err => { console.log(err) })
            }
        },
        created(){
            this.fetchOrders(),
            this.fetchTodaysCuttingOrders()
        }
    });
</script>
@endsection