@extends('layouts.app') @section('content')
<div class="container" id="app">

  <!--Order Breakups-->
  <div class="card">
    <h5 class="card-header">Order Breakups</h5>
    <div class="card-body">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Order Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Loading Date</th>
            <th scope="col">SAM</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order, key in orderBreakups">
          <th scope="row">@{{order.id}}</th>
          <td>@{{order.order_id}}</td>
          <td>@{{order.qty}}</td>
          <td>@{{order.loading_date}}</td>
          <td>@{{order.sam}}</td>
          <td>
            <button type="button" class="btn btn-danger" @click="delOrdersB(key, order.id)">Delete</button>
          </td>
          </tr>
        </tbody>
      </table>
      <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#OrderBModal">
        Add Order Breakup
      </button>
    </div>
  </div>

  <!-- Modal -->
<div class="modal fade" id="OrderBModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Order Breakup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Order Name</label>
          <select v-model="newBreakup.order_id" name="order_id" class="form-control">
           <option v-for="order in orders" :value="order.id">@{{order.order_name}}</option>
          </select>
        </div>
        <div class="form-group">
          <label>Quantity</label>
          <input type="number" class="form-control" name="qty" v-model="newBreakup.qty" placeholder="Qunatity">
        </div>
        <div class="form-group">
          <label>Loading Date</label>
          <input type="date" class="form-control" name="loading_date" v-model="newBreakup.loading_date" placeholder="Loading Date">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" @click="addBreakup" data-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!--Order Functions-->
  <div class="card">
    <h5 class="card-header">Orders</h5>
    <div class="card-body">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Order Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Delivery Date</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order, key in orders">
          <th scope="row">@{{order.id}}</th>
          <td>@{{order.order_name}}</td>
          <td>@{{order.qty}}</td>
          <td>@{{order.delivery_date}}</td>
          <td>
            <button type="button" class="btn btn-danger" @click="delOrders(key, order.id)">Delete</button>
          </td>
          </tr>
        </tbody>
      </table>
      <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#OrderModal">
        Add Order
      </button>
    </div>
  </div>

  <!-- Modal -->
<div class="modal fade" id="OrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Orders</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Order Name</label>
          <input type="text" placeholder="Order Name" class="form-control" name="order_name" v-model="newOrder.order_name">
        </div>
        <div class="form-group">
          <label>Style Name</label>
          <select v-model="newOrder.style_id" name="style_id" class="form-control">
           <option v-for="style in styles" :value="style.id">@{{style.styles_name}}</option>
          </select>
        </div>
        <div class="form-group">
          <label>Quantity</label>
          <input type="number" class="form-control" name="qty" v-model="newOrder.quantity" placeholder="Qunatity">
        </div>
        <div class="form-group">
          <label>Delivery Date</label>
          <input type="date" class="form-control" name="qty" v-model="newOrder.delivery_date" placeholder="Qunatity">
        </div>
        <div class="form-group">
          <label>SAM</label>
          <input type="number" class="form-control" name="sam" v-model="newOrder.sam" placeholder="SAM">
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
  <!-- Modal -->
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
<script src="{{ asset('./js/moment.js')}}" charset="utf-8"></script>
<script type="text/javascript">
  var app = new Vue({
    el: '#app',
    data() {
      return {
        factory_id: 1,
        styles: [],
        newStyle: {
          id: '',
          style_name: '',
          brand_name: '',
          factory_id: 1
        },
        orders:[],
        newOrder: {
          style_id: '',
          order_name: '',
          quantity: '',
          delivery_date: '',
          sam:'',
          factory_id: 1
        },
        orderBreakups: [],
        newBreakup: {
          order_id: '',
          style_id: '',
          qty: '',
          loading_date: '',
          sam: '',
          factory_id: 1
        }
      }
    },
    watch: {

    },
    methods: {
      // Styles
      saveStyle() {
        axios.post('/add/style', this.$data.newStyle).then(res => {
          this.styles.unshift(res.data);
          this.newStyle.id = ''
          this.newStyle.style_name=''
          this.newStyle.brand_name = ''
        }).catch(err => { console.log(err) })
      },
      fetchStyles() {
        axios.get('/get/styles/' + this.factory_id).then(res => {
          this.styles = res.data
        }).catch(err => { console.log(err) })
      },
      delStyle(key, id){
        axios.get('/del/styles/' + id).then(res => {
          if(res.data){
            this.styles.splice(key, 1);
          }
        }).catch(err => { console.log(err) })
      },
      // Orders
      fetchOrders(){
        axios.get('/get/orders/' + this.factory_id).then(res => {
          this.orders = res.data
        }).catch(err => { console.log(err)})
      },
      addOrder(){
        axios.post('/add/order', this.$data.newOrder).then(res => {
          this.orders.unshift(res.data);
          this.newOrder.style_id= ''
          this.newOrder.order_name= ''
          this.newOrder.quantity= ''
          this.newOrder.delivery_date= ''
          this.newOrder.sam=''
        }).catch(err => {console.log(err)})
      },
      delOrders(key, id){
        axios.get('/del/orders/' + id).then(res => {
          if(res.data){
            this.orders.splice(key, 1);
          }
        }).catch(err => { console.log(err) })
      },
      // Order Breakups
      addBreakup(){
        this.newBreakup.style_id = this.orders[parseInt(this.newBreakup.order_id) - 1].style_id
        this.newBreakup.sam = this.orders[parseInt(this.newBreakup.order_id) - 1].sam
        axios.post('/add/order/breakup', this.$data.newBreakup).then( res => {
          console.log(res.data);
          this.orderBreakups.unshift(res.data);
        }).catch(err => { console.log(err)})
      },
      fetchBreakups(){
        axios.get('/get/orders/breakups/'+ this.factory_id).then(res => {
          this.orderBreakups = res.data
        }).catch(err => {console.log(err)})
      },
      delOrdersB(key, id){
        axios.get('/del/orders/breakups/'+id).then(res => {
          if(res.data){
            this.orderBreakups.splice(key, 1);
          }
        }).catch(err => {console.log(err)})
      }

    }, 
    created() {
      this.fetchStyles(),
      this.fetchOrders(),
      this.fetchBreakups()
    }
  });

</script> @endsection