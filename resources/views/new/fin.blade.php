@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <div class="card">
    <h5 class="card-header">Featured</h5>
    <div class="card-body">
        <table class="table">
        <thead class="thead-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Order Id</th>
            <th scope="col">Finished Quantity</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="f, key in finishes">
                <td>@{{ key + 1 }}</td>
                <td>@{{ f.order_id }}</td>
                <td>@{{ f.fqty }}</td>
            </tr>
        </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#finishingModal">
         Add Finishing Data
        </button>
    </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="finishingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <label for="">Order Name</label>
            <select name="order_id" class="form-control" v-model="finOrder.order_id">
                <option v-for="order in orders" :value="order.id">@{{order.order_name}}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Finished Quantity</label>
            <input type="text" name="finishedqty" v-model="finOrder.fqty" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" @click="addFinish"  data-dismiss="modal">Save changes</button>
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
                factory_id:{{Auth::user()->factory_id}},
                orders:[],
                finishes:[],
                finOrder:{
                    order_id:'',
                    fqty:'',
                    factory_id: {{Auth::user()->factory_id}}
                }
            }
        }, 
        methods:{
            fetchOrders(){
             axios.get(`/get/orders/${this.factory_id}`).then(res => {
             this.orders = res.data
             }).catch(err => { console.log(err) })
            },
            addFinish(){
             axios.post('/add/finishing/orders', this.$data.finOrder).then(res => {
                this.finishes.unshift(res.data)
             }).catch(err => { console.log(err) })
            },
            fetchFinish(){
                axios.get(`/get/finishing/orders/${this.factory_id}`).then(res => {
                    this.finishes = res.data
                }).catch(err => { console.log(err) })
            }
        },
        created(){
            this.fetchOrders(),
            this.fetchFinish()
        }
    });
</script>
@endsection