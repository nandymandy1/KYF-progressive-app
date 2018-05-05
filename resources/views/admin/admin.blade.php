@extends('layouts.app')

@section('content')

  <div class="container">
    <h3>Factory List</h3>
    @if (Auth::user()->type == 'superadmin')
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Add New Factory
      </button>
    @endif
    <div class="" id="app">
      <span class="pull-right" v-if="loading">
        <i class="fa fa-refresh fa-spin fa-1x fs-fw"></i>
      </span>
      <br>
      <div class="row mb-3">
        <div class="col-md-4 col-sm-6 mr-auto">
          <input type="text" name="search" placeholder="Search" v-model="searchQuery" class="form-control" value="">
        </div>
      </div>
      <!--Success Message-->
      <div class="alert bg-green alert-dismissible" role="alert" v-if="success.length > 0">
        <button type="button" class="close" @click="hideMsg"><span aria-hidden="true">&times;</span></button>
          @{{ success }}
      </div>
      <!--Start of Factories list-->
      <ul class="list-group">
        <li v-for="factory, key in temp" class="list-group-item">
          @{{ factory.name }}
          <div class="pull-right">
            <button type="button" @click="disable_enable(key, factory)" class="btn btn-sm btn-success ml-auto" v-if="factory.isActive == 1"  name="button">Disable</button>
            <button type="button" @click="disable_enable(key, factory)" class="btn btn-sm ml-auto" v-else name="button">Enable</button>
            <a class="btn btn-primary btn-sm mr-auto" name="button" :href="'/admin/factory/master/' + factory.id">View Reports</a>
            @if (Auth::user()->type == 'superadmin')
              <button type="button" class="btn btn-danger btn-sm" @click="del(key, factory.id)" name="button">Delete Factory</button>
            @endif
          </div>
        </li>
      </ul>
      <!--End of Factories list-->
      <!--Modal-->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-blue">
              <h5 class="modal-title" id="exampleModalLabel">Add Factory</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body bg-grey">
              <div class="alert alert-danger" v-if="error.length !=0">
                  @{{ error }}
              </div>
              <div class="form-group">
                <label for="name">Factory Name</label>
                <input type="text" v-model="newfactory.name" name="name" placeholder="Factory Name" class="form-control">
              </div>
              <div class="form-group">
                <label for="name">Active</label>
                <select class="form-control" name="isActive" v-model="newfactory.isActive">
                  <option value="1">Enable</option>
                  <option value="0">Disable</option>
                </select>
              </div>
            </div>
            <div class="modal-footer bg-blue">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn bg-default wave-effect" @click="addFactory" data-dismiss="modal">Add</button>
            </div>
          </div>
        </div>
      </div>
      <!--Modal-->
    </div>
  </div>

@endsection

@section('scripts')
  <script type="text/javascript">
  var app = new Vue({
    el: '#app',
    data() {
      return{
        factories:{},
        temp:{},
        loading: false,
        errors:{},
        error:'',
        newfactory:{
          name:'',
          isActive:''
        },
        searchQuery:'',
        success: ''
      }
    },
    watch:{
      searchQuery(){
        if(this.searchQuery.length > 0){
          this.temp = this.factories.filter((factory) => {
            return Object.keys(factory).some((key) => {
              let string = String(factory[key])
              return string.toLowerCase().indexOf(this.searchQuery.toLowerCase()) > -1
            })
          });
        } else {
          this.temp = this.factories
        }
      }
    },
    created(){
      // fetch all the factories from the database
      this.fetchFactory()
    },
    methods:{
      disable_enable(key, id){
        this.loading = !this.loading
        var factory = this.factories[key]
        if(this.factories[key].isActive == 1){
          if(confirm("Are you sure, You want to revoke all the rights from this factory")){
            factory.isActive = 0
            axios.get(`/admin/factory/endis/${factory.id}`)
            .then((response) => {
              console.log(response)
              this.fetchFactory()
            })
            .catch((error) => this.errors = error.response.data.errors)
          }
        }
        else{
          if(confirm("Are you sure, You want to Activate this factory?")){
            factory.isActive = 1
            axios.get(`/admin/factory/endis/${factory.id}`)
            .then((response) => {
              console.log(response)
              this.fetchFactory()
            })
            .catch((error) => this.errors = error.response.data.errors)
          }
        }
        this.loading = !this.loading
      },
      del(key, id){
        this.loading = !this.loading
        if(confirm("Are you sure to delete this factory?")){
          axios.post(`/admin/factorydel/${id}`)
          .then((response) => {
            this.factories.splice(key, 1)
            this.success = 'Factory deleted from the list successfully'
            // this.fetchFactory()
          }).catch((error) => {
            this.errors = error.response.data.errors
          })
        }
        this.loading = !this.loading
      },
      fetchFactory(){
        // fetch factory
        axios.post('/admin/factories').then((response) => this.factories = this.temp = response.data)
        .catch((error) => this.errors = error.response.data.errors)
      },
      addFactory(){
        // To add any factory in the system by the admin
        if(this.newfactory.isActive != '' && this.newfactory.name != ''){
          axios.post('/admin/factory', this.$data.newfactory).then((response) => {
            this.newfactory.name = '';
            this.newfactory.isActive = '';
            console.log(response.data);
            this.factories.push(response.data);
            this.factories.sort(function(a, b){
              if(a.name > b.name){
                return 1;
              } else {
                return -1;
              }
            })
          }).catch((error) => this.errors = error.response.data.errors)
          this.error = ''
          this.success = 'Factory added in the list Successfully'
        } else {
          this.error = "Either you activate or deactivate the factory but it cannot be empty"
        }
      },
      hideMsg(){
        this.success = ''
      }
    }
  });
</script>
@endsection
