@extends('layouts.app') @section('content')
<div class="container" id="app">
<!--Orders-->
<div class="card">
  <h5 class="card-header">Orders</h5>
  <div class="card-body">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Style</th>
          <th scope="col">Quantity</th>
          <th scope="col">Delivery Date</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order, key in orders">
        <td>@{{order.id}}</td>
        <td>@{{order.order_name}}</td>
        <td>@{{order.style_name}}</td>
        <td>@{{order.qty}}</td>
        <td>@{{order.delivery_date}}</td>
        <td>
          <a :href="'/order/reports/' + order.id" class="btn bg-green">View Reports</a>
          <button type="button" class="btn btn-danger" @click="delOrder(key, order.id)">Delete</button>
        </td>
        </tr>
      </tbody>
    </table>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
      Add Order
    </button>
  </div>
</div>
<!--Order Functions-->


<!-- Order Modal -->
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
          <input type="text" name="order_name" v-model="newOrder.order_name" class="form-control">
        </div>
        <div class="form-group">
          <label for="">Style Name</label>
          <select id="" name="style_name" class="form-control" v-model="newOrder.style_name">
            <option :value="s.styles_name" v-for="s in styles">@{{s.styles_name}}</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Quantity</label>
          <input type="number" name="quantity" v-model="newOrder.qty" class="form-control">
        </div>
        <div class="form-group">
          <label for="">SAM</label>
          <input type="number" name="sam" v-model="newOrder.sam" class="form-control">
        </div>
        <div class="form-group">
          <label for="">Delivery Date</label>
          <input type="date" name="delivery_date" v-model="newOrder.delivery_date" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="addOrder">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!--Styles Functions goes here-->
<div class="card">
  <h5 class="card-header">Styles</h5>
  <div class="card-body">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Styles</th>
          <th scope="col">Brand</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="style, key in styles">
          <th scope="row">@{{style.id}}</th>
          <td>@{{style.styles_name}}</td>
          <td>@{{style.brand_name}}</td>
          <td>
            <button type="button" class="btn btn-danger" @click="delStyle(key, style.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#StyleModal">
      Add Style
    </button>
  </div>
</div>
<!-- Style Modal -->
<div class="modal fade" id="StyleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Style</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-white">
        <div class="form-group">
          <label>Style Name</label>
          <input type="text" class="form-control" name="style_name" v-model="newStyle.style_name" placeholder="Style Name">
        </div>
        <div class="form-group">
          <label>Brand Name</label>
          <input type="text" class="form-control" name="brand_name" v-model="newStyle.brand_name" placeholder="Brand Name">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="saveStyle">Save changes</button>
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
        factory_id: {{Auth::user()->factory_id}},
        styles: [],
        newStyle: {
          id: '',
          style_name: '',
          brand_name: '',
          factory_id: 1
        },
        orders:[],
        newOrder:{
          order_name:'',
          style_name:'',
          qty:'',
          sam:'',
          delivery_date:'',
          factory_id:{{Auth::user()->factory_id}}
        }
      }
    },
    methods: {
      // Styles
      saveStyle() {
        axios.post('/add/style', this.$data.newStyle).then(res => {
          this.styles.unshift(res.data);
          this.newStyle.id = ''
          this.newStyle.style_name = ''
          this.newStyle.brand_name = ''
        }).catch(err => { console.log(err) })
      },
      fetchStyles() {
        axios.get('/get/styles/' + this.factory_id).then(res => {
          this.styles = res.data
        }).catch(err => { console.log(err) })
      },
      delStyle(key, id) {
        axios.get('/del/styles/' + id).then(res => {
          if (res.data) {
            this.styles.splice(key, 1);
          }
        }).catch(err => { console.log(err) })
      },
      addOrder(){
        axios.post('/add/order', this.$data.newOrder).then( res => {
          this.orders.unshift(res.data)
        }).catch(err => { console.log(err) })
      },
      // fetch all the orders
      fetchOrders(){
        axios.get(`/get/orders/${this.factory_id}`).then(res => {
          this.orders = res.data
        }).catch(err => { console.log(err) })
      },
      // delete Order
      delOrder(key, id){
        axios.get(`/del/orders/${id}`).then(res => {
          if(res.data){
            this.orders.splice(key, 1)
          }
        }).catch(err => console.log(err))
      }
    },
    created() {
      this.fetchStyles(),
      this.fetchOrders()
    }
  });
</script> @endsection