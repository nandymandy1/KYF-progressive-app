@extends('layouts.app') @section('content')
<div class="container" id="app">
    <div class="card">
        <h5 class="card-header">Featured</h5>
        <div class="card-body">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Order Id</th>
                <th scope="col">Inspected Qunatity</th>
                <th scope="col">Passed Pieces</th>
                <th scope="col">DHU</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="q, key in quality">
                    <td>@{{ key+1 }}</td>
                    <td>@{{ q.order_id }}</td>
                    <td>@{{ q.qty }}</td>
                    <td>@{{ q.ppcs }}</td>
                    <td>@{{ q.dhu }}</td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Add Quality Data
        </button>    
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
            <label for="">Order Name</label>
            <select name="order_id" class="form-control" v-model="newQuality.order_id">
                <option v-for="order in orders" :value="order.id">@{{order.order_name}}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Inspected Quantity</label>
            <input type="number" name="qty" v-model="newQuality.qty" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Passed Pieces</label>
            <input type="number" name="p_pcs" v-model="newQuality.p_pcs" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="addQuality">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>
@endsection @section('scripts')
<script>
    var app = new Vue({
        el: '#app',
        data() {
            return {
                factory_id: 1,
                orders: [],
                quality:[],
                newQuality:{
                    factory_id: 1,
                    order_id: '',
                    p_pcs: '',
                    qty:''
                }
            }
        },
        methods: {
            fetchOrders() {
                axios.get(`/get/orders/${this.factory_id}`).then(res => {
                    this.orders = res.data
                    console.log(this.orders)
                }).catch(err => { console.log(err) })
            },
            addQuality(){
                axios.post(`/add/quality/orders`, this.$data.newQuality).then(res => {
                    this.quality.unshift(res.data);
                }).catch(err => console.log(err))
            },
            fetchQualityData(){
                axios.get(`/get/quality/orders/${this.factory_id}`).then(res => {
                    this.quality = res.data;
                }).catch(err => console.log(err))
            }
        },
        created() {
            this.fetchOrders(),
            this.fetchQualityData()
        }
    });
</script> @endsection