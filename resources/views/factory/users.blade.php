@extends('layouts.app')
@section('content')
  <div class="container" id="app">
    <h3>@{{ layout }}</h3>
    <br>
    <div class="row">
      <div class="col-md-4 col-sm-6 mr-auto">
        <input type="text" name="search" placeholder="Search" v-model="searchQuery" class="form-control" value="">
      </div>
    </div>
    <br>
    <!--Starting of Users list-->
    <ul class="list-group">
      <li v-for="user, key in temp" class="list-group-item">
        @{{ user.name }}<br>
        <b>@{{ user.job }}</b>
        <div class="pull-right">
          <button type="button" @click="disable_enable(key, user)" class="btn btn-sm btn-success ml-auto" v-if="user.isActive == 1"  name="button">Disable</button>
          <button type="button" @click="disable_enable(key, user)" class="btn btn-sm ml-auto" v-else name="button">Enable</button>
        </div>
      </li>
    </ul><!--End of Users list-->
  </div>
@endsection
@section('scripts')
<script type="text/javascript">
  var app = new Vue({
    el: '#app',
    data(){
      return{
        layout: 'Users',
        users:[],
        temp:{},
        searchQuery:'',
        id:{{$id}}
      }
    },
    created(){
      // at the runitime initial method
      this.fetchUsers()
    },
    methods:{
      fetchUsers(){
        // fetch users
        axios.post(`/master/usersfetch/${this.id}`).then((response) => {
          this.users = this.temp = response.data
          console.log(this.users);
        })
        .catch((error) => this.errors = error.response.data.errors)
      },
      disable_enable(key, id){
        var user = this.users[key]
        if(this.users[key].isActive == 1){
          if(confirm("Are you sure, You want to revoke all the rights from this User?")){
            user.isActive = 0
            axios.get(`/admin/user/endis/${user.id}`)
            .then((response) => console.log(response))
            .catch((error) => this.errors = error.response.data.errors)
          }
        }
        else{
          if(confirm("Are you sure, You want to Activate this User?")){
            user.isActive = 1
            axios.get(`/admin/user/endis/${user.id}`)
            .then((response) => console.log(response))
            .catch((error) => this.errors = error.response.data.errors)
          }
        }
        this.fetchUsers();
      }
    },
    watch:{
      searchQuery(){
        if(this.searchQuery.length > 0){
          this.temp = this.users.filter((user) => {
            return Object.keys(user).some((key) => {
              let string = String(user[key])
              return string.toLowerCase().indexOf(this.searchQuery.toLowerCase()) > -1
            })
          });
        } else {
          this.temp = this.users
        }
      }
    }
  });
</script>
@endsection
