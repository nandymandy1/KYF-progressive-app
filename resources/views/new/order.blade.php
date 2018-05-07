@extends('layouts.app') @section('content')

<div class="container" id="app">
    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="body bg-green">
                    <div class="m-b--35 font-bold">ORDER DETAILS</div>
                    <ul class="dashboard-stat-list">
                        <li>Style Name:<span class="pull-right">@{{ order.style_name }}</span></li>
                        <li>Order Name:<span class="pull-right">@{{ order.order_name }}</span></li>
                        <li>Order Quantity:<span class="pull-right">@{{ order.qty}} pieces</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="body bg-blue">
                    <div class="m-b--35 font-bold">ORDER PROGRESS</div>
                    <ul class="dashboard-stat-list">
                        <li>Cutting Quantity:<span class="pull-right">@{{ order.cqty }}</span></li>
                        <li>Sewed Quantity:<span class="pull-right">@{{ order.sqty }}</span></li>
                        <li>Finished Quantity:<span class="pull-right">@{{ order.fqty }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="body bg-pink">
                    <div class="m-b--35 font-bold">ORDER TIME</div>
                    <ul class="dashboard-stat-list">
                        <li>Order Placed:<span class="pull-right">@{{ order.date }}</span></li>
                        <li>Delivery Date:<span class="pull-right">@{{ order.delivery_date }}</span></li>
                        <li>Number of Days:<span class="pull-right">@{{ order.diff }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>     
    <!--Charts Goes Here-->       
    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header bg-red">Order Progress</div>
                <div class="body">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Task</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Cutting</td>
                                <td><div class="progress"><div class="progress-bar" :class="getClass(p_cut)" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" :style="{width: p_cut + '%'}"></div></div></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Sewing</td>
                                <td><div class="progress"><div class="progress-bar" :class="getClass(p_sew)" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"  :style="{width: p_sew + '%'}"></div></div></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Finishing</td>
                                <td><div class="progress"><div class="progress-bar" :class="getClass(p_fin)" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" :style="{width: p_fin + '%'}"></div></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>  
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header bg-blue">Cutting</div>
                <div class="body">
                    <canvas id="cut" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header bg-green">Sewing</div>
                <div class="body">
                    <canvas id="sew" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header bg-pink">Efficiency</div>
                <div class="body">
                    <canvas id="effi" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header bg-yellow">Finishing</div>
                <div class="body">
                    <canvas id="fin" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header bg-orange">DHU</div>
                <div class="body">
                    <canvas id="dhu" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header bg-info">Passed vs Failed</div>
                <div class="body">
                    <canvas id="quality" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection @section('scripts')
<script src="{{ asset('./js/moment.js')}}" charset="utf-8"></script>
<script>
    var app = new Vue({
        el: '#app',
        data() {
            return {
                order_id: {{ $id }},
                cut: [],
                sew: [],
                qua: [],
                fin: [],
                order: {},
                style_name:'',
                p_sew:'',
                p_cut:'',
                p_fin:''
    }
        },
    methods: {
        getData(){
            axios.get(`/get/order/details/${this.order_id}`).then(res => {
                this.cut = res.data.cut
                this.sew = res.data.sew
                this.fin = res.data.fin
                this.qua = res.data.qua
                
                // Cutting Charts Goes Here
                var dates = []
                var cut = []
                for(i=0; i<this.cut.length; i++){
                    dates.push(moment(new Date(this.cut[i].created_at)).format("D-MMM"))
                    cut.push(parseInt(this.cut[i].qty))
                }

                var cutChart = document.getElementById("cut").getContext('2d');
                var cut = new Chart(cutChart, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                        label: "Cutting",
                        data: cut,
                        backgroundColor: 'rgba(0, 188, 212, 0.8)'
                    }]
                },
                  options: {
                    responsive: true,
                    legend: {
                        display:true,
                        position:'bottom'
                    },
                    scales: {
                        yAxes:[{
                        scaleLabel:{
                            display:true,
                            labelString:'Pieces'
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        },
                        ticks: {
                            beginAtZero: true
                        }
                        }],
                        xAxes:[{
                        scaleLabel:{
                            display:true,
                            labelString:'Dates'
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                        }]
                    }
                  }
                });

                // Sewing Chart
                dates = []
                var sew = []
                var eff = []
                for(i=0; i<this.sew.length; i++){
                    dates.push(moment(new Date(this.sew[i].created_at)).format("D-MMM"))
                    sew.push(parseInt(this.sew[i].qty))
                    eff.push(parseFloat(this.sew[i].effi))
                }

                var sewChart = document.getElementById("sew").getContext('2d');
                var sew = new Chart(sewChart, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                        label: "Sewing",
                        data: sew,
                        backgroundColor: 'rgba(127, 140, 141, 0.8)'
                    }]
                },
                  options: {
                    responsive: true,
                    legend: {
                        display:true,
                        position:'bottom'
                    },
                    scales: {
                        yAxes:[{
                        scaleLabel:{
                            display:true,
                            labelString:'Pieces'
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        },
                        ticks: {
                            beginAtZero: true
                        }
                        }],
                        xAxes:[{
                        scaleLabel:{
                            display:true,
                            labelString:'Dates'
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                        }]
                    }
                  }
                });
                var effiChart = document.getElementById("effi").getContext('2d');
                var effi = new Chart(effiChart, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: "Efficiency",
                        data: eff,
                        borderColor: 'rgba(41, 128, 185, 0.75)',
                          backgroundColor: 'rgba(127, 179, 213, 0.3)',
                          pointBorderColor: 'rgba(127, 179, 213, 0)',
                          pointBackgroundColor: 'rgba(212, 230, 241, 0.9)',
                          pointBorderWidth: 1
                    }]
                },
                  options: {
                    responsive: true,
                    legend: {
                        display:true,
                        position:'bottom'
                    },
                    scales: {
                        yAxes:[{
                        scaleLabel:{
                            display:true,
                            labelString:'Efficiency(%)'
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        },
                        ticks: {
                            beginAtZero: true
                        }
                        }],
                        xAxes:[{
                        scaleLabel:{
                            display:true,
                            labelString:'Dates'
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                        }]
                    }
                  }
                });
                // Finishing Chart
                dates = []
                var fin = []
                for(i=0; i<this.fin.length; i++){
                    dates.push(moment(new Date(this.fin[i].created_at)).format("D-MMM"))
                    fin.push(parseInt(this.fin[i].fqty))
                }
                
                var finChart = document.getElementById("fin").getContext('2d');
                var fini = new Chart(finChart, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                        label: "Finishing",
                        data: fin,
                        backgroundColor: 'rgba(245, 176, 65, 0.8)'
                    }]
                },
                  options: {
                    responsive: true,
                    legend: {
                        display:true,
                        position:'bottom'
                    },
                    scales: {
                        yAxes:[{
                        scaleLabel:{
                            display:true,
                            labelString:'Pieces'
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        },
                        ticks: {
                            beginAtZero: true
                        }
                        }],
                        xAxes:[{
                        scaleLabel:{
                            display:true,
                            labelString:'Dates'
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                        }]
                    }
                  }
                });


                // Quality Chart Data
                dates = []
                var dhu = []
                var passed = []
                var failed = []
                var qty = []
                for(i=0; i<this.qua.length; i++){
                    dates.push(moment(new Date(this.qua[i].created_at)).format("D-MMM"))
                    dhu.push(parseFloat(this.qua[i].dhu))
                    qty.push(parseInt(this.qua[i].qty))
                    passed.push(parseInt(this.qua[i].ppcs))
                    failed.push(parseInt(this.qua[i].qty)- parseInt(this.qua[i].ppcs))
                }
                
                var effiChart = document.getElementById("dhu").getContext('2d');
                var effi = new Chart(effiChart, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: "DHU",
                        data: dhu,
                        borderColor: 'rgba(231, 76, 60, 0.75)',
                          backgroundColor: 'rgba(230, 75, 58, 0.3)',
                          pointBorderColor: 'rgba(230, 75, 58, 0)',
                          pointBackgroundColor: 'rgba(230, 75, 58, 0.9)',
                          pointBorderWidth: 1
                    }]
                },
                  options: {
                    responsive: true,
                    legend: {
                        display:true,
                        position:'bottom'
                    },
                    scales: {
                        yAxes:[{
                        scaleLabel:{
                            display:true,
                            labelString:'DHU(%)'
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        },
                        ticks: {
                            beginAtZero: true
                        }
                        }],
                        xAxes:[{
                        scaleLabel:{
                            display:true,
                            labelString:'Dates'
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                        }]
                    }
                  }
                });

                var effiChart = document.getElementById("quality").getContext('2d');
                var effi = new Chart(effiChart, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                        label: "Total Quantity Inspected",
                        data: qty,
                        backgroundColor: 'rgba(155, 89, 182, 0.8)'
                    },{
                        label: "Passed Quantity",
                        data: passed,
                        backgroundColor: 'rgba(40, 180, 99, 0.8)'
                    },{
                        label: "Failed Quantity",
                        data: failed,
                        backgroundColor: 'rgba(231, 76, 60, 0.8)'
                    }]
                },
                  options: {
                    responsive: true,
                    legend: {
                        display:true,
                        position:'bottom'
                    },
                    scales: {
                        yAxes:[{
                        scaleLabel:{
                            display:true,
                            labelString:'Pieces'
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        },
                        ticks: {
                            beginAtZero: true
                        }
                        }],
                        xAxes:[{
                        scaleLabel:{
                            display:true,
                            labelString:'Dates'
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                        }]
                    }
                  }
                });

            }).catch(err => console.log(err))
        },
        getOrder(){
            axios.get(`/get/order/data/${this.order_id}`).then(res => {
                this.order = res.data
                var delivery = moment(new Date(this.order.delivery_date)).format("D-MMM-YYYY")
                var orderDate = moment(new Date(this.order.created_at)).format("D-MMM-YYYY")
                var leadTime = (moment(this.order.delivery_date)).diff(moment(this.order.created_at), "days")
                this.order.date = orderDate
                this.order.delivery_date = delivery
                this.order.diff = leadTime
                this.p_cut = ((parseInt(this.order.cqty)/parseInt(this.order.qty))*100).toFixed(2)
                this.p_sew = ((parseInt(this.order.sqty)/parseInt(this.order.qty))*100).toFixed(2)
                this.p_fin = ((parseInt(this.order.fqty)/parseInt(this.order.qty))*100).toFixed(2)
            }).catch(err => console.log(err))
        },
        getClass(pro){
            if(pro > 0 && pro <= 25){
                return "bg-red"
            } else if(pro > 25 && pro <= 50){
                return "bg-orange"
            } else if(pro > 50 && pro <= 75){
                return "bg-light-green"
            } else {
                return "bg-green"
            }
        }
    },
    created(){
        this.getData(),
        this.getOrder()
    }
    });
</script> @endsection