@extends('layouts.app') @section('content')
<div class="container" id="app">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#lineModal">
        Add Line
    </button>

    <!-- Modal -->
    <div class="modal fade" id="lineModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label>Line No.</label>
                        <input type="text" name="line_no" v-model="newline.line_no" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Number of Sewing Operators</label>
                        <input type="text" name="sopr" v-model="newline.sopr" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Number of Kaja Operators</label>
                        <input type="text" name="kopr" v-model="newline.kopr" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Number of Helpers</label>
                        <input type="text" name="hlpr" v-model="newline.hlpr" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Number of Checkers</label>
                        <input type="text" name="chkr" v-model="newline.chkr" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Order Breakups</label>
                        <select name="style_id" v-model="newline.style_id" class="form-control">
                            <option v-for="b in breakups" :value="b.order_id">@{{b.order_id}}</option>
                        </select>
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
@endsection @section('scripts')
<script src="{{ asset('./js/moment.js')}}" charset="utf-8"></script>
<script type="text/javascript">
    var app = new Vue({
        el: '#app',
        data() {
            return {
                newline: {
                    line_no: '',
                    sopr: '',
                    kopr: '',
                    sam: '',
                    hlpr: '',
                    chkr: '',
                    factory_id: 1,
                    style_id: '',
                    eff: ''
                },
                factory_id: 1,
                lines: [],
                breakups: [],
                orders: [],
                styles:[]
            }
        },
        methods: {
            fecthTodayLine() {
                axios.get('/get/today/line/' + this.factory_id).then({

                })
                    .catch(err => { console.log(err) })
            },
            addTodayLine() {

            },
            fecthBreakups() {
                axios.get('/get/orders/breakups/' + this.factory_id).then(res => {
                    this.breakups = res.data
                    console.log(this.breakups);
                }).catch(err => { console.log(err) })
            },
            fetchStyles(){
                axios.get('/get/styles/' + this.factory_id).then(res => {
                this.styles = res.data
                }).catch(err => { console.log(err) })
            },
            fetchOrders() {
                axios.get('/get/orders/' + this.factory_id).then(res => {
                    this.orders = res.data
                    console.log(this.orders);
                    console.log(this.orders)
                }).catch(err => { console.log(err) })
            },
            //Add new Line
            addLine(){
                console.log();
            }
        },
        created() {
            this.fecthBreakups(),
            this.fetchOrders()
        }
    });
</script> @endsection