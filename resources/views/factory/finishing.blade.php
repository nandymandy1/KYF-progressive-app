@extends('layouts.app')

@section('content')

<div class="container" id="app">
@if (Auth::user()->job != 'master')
  @if($today)
    <div class="row">
      <div class="col-md-6">
        <a href="/factory/finishinginput" class="btn btn-md btn-primary">Add Today's Data</a>
      </div>
    </div>
  @endif
@endif
  <br>
  <h2>Finishing Dashboard</h2>
  <div class="row">
    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-blue">
          Sewing vs Packed
        </div>
        <div class="card-body">
          <canvas id="divprsr" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-red">
          Fed into Finishing vs Finished Goods
        </div>
        <div class="card-body">
          <canvas id="divff" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-light-green">
          Finished Goods
        </div>
        <div class="card-body">
          <canvas id="divfg" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-light-blue">
          Finishing WIP
        </div>
        <div class="card-body">
          <canvas id="divwip" height="150"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('scripts')
  <script src="{{ asset('./js/moment.js')}}" charset="utf-8"></script>
  <script type="text/javascript">
    var app = new Vue({
      el: '#app',
      data(){
        return{
          factory_id: {{Auth::user()->factory_id}},
          report:{},
          temp:{},
          errors:{}
        }
      },
      methods:{
        fetchFinishing(){
          axios.post(`/reports/finishing/${this.factory_id}`)
          .then(
            (response) => {
              console.log(response)
              this.report = this.temp = response.data
              console.log(this.report);
              var feed = [];
              var pkd = [];
              var dates = [];
              var income = [];
              var wip = [];
              var twip = [];

              for(i = this.report.length -1; i >=0 ; i--){
                dates.push(moment(new Date(this.report[i].created_at)).format("D-MMM"));
                pkd.push(this.report[i].pkd);
                income.push(this.report[i].income);
                feed.push(this.report[i].feed);
                wip.push(parseInt(this.report[i].income - this.report[i].pkd));
                if(i == this.report.length -1){
                  twip.push(parseInt(this.report[i].income - this.report[i].pkd));
                } else {
                  twip.push(twip[twip.length -1] + parseInt(this.report[i].income - this.report[i].pkd));
                }
              }

              var wipChart = document.getElementById("divwip").getContext('2d');
              var myWip = new Chart(wipChart, {
              type: 'bar',
              data: {
                  labels: dates,
                  datasets: [{
                      label: "Cumulative WIP",
                      data: twip,
                      backgroundColor: 'rgba(0, 188, 212, 0.8)'
                  }, {
                          label: "Daily WIP",
                          data: wip,
                          backgroundColor: 'rgba(233, 30, 99, 0.8)'
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
                      }
                    }],
                    xAxes:[{
                      scaleLabel:{
                        display:true,
                        labelString:'Dates'
                      }
                    }]
                  }
              }
              });

              var psrChart = document.getElementById("divprsr").getContext('2d');
              var myPsr = new Chart(psrChart, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: "Total Packed Quantity",
                        data: pkd,
                        borderColor: 'rgba(0, 188, 212, 0.75)',
                        backgroundColor: 'rgba(0, 188, 212, 0.3)',
                        pointBorderColor: 'rgba(0, 188, 212, 0)',
                        pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                        pointBorderWidth: 1
                    }, {
                            label: "Pieces Recieved From Sewing",
                            data: income,
                            borderColor: 'rgba(233, 30, 99, 0.75)',
                            backgroundColor: 'rgba(233, 30, 99, 0.3)',
                            pointBorderColor: 'rgba(233, 30, 99, 0)',
                            pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
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
                        ticks:{min:0},
                        scaleLabel:{
                          display:true,
                          labelString:'Pieces'
                        }
                      }],
                      xAxes:[{
                        scaleLabel:{
                          display:true,
                          labelString:'Dates'
                        }
                      }]
                    }
                }
              });

              var ffChart = document.getElementById("divff").getContext('2d');
              var ffPsr = new Chart(ffChart, {
              type: 'bar',
              data: {
                  labels: dates,
                  datasets: [{
                      label: "Pieces fed into finishing",
                      data: feed,
                      backgroundColor: 'rgba(0, 188, 212, 0.8)'
                  }, {
                          label: "Packed pieces",
                          data: pkd,
                          backgroundColor: 'rgba(233, 30, 99, 0.8)'
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
                      ticks:{min:0},
                      scaleLabel:{
                        display:true,
                        labelString:'Pieces'
                      }
                    }],
                    xAxes:[{
                      scaleLabel:{
                        display:true,
                        labelString:'Dates'
                      }
                    }]
                  }
              }
            });

            var fgChart = document.getElementById("divfg").getContext('2d');
            var fgPsr = new Chart(fgChart, {
              type: 'line',
              data: {
                  labels: dates,
                  datasets: [{
                      label: "Daily Packed Quantity",
                      data: pkd,
                      borderColor: 'rgba(0, 188, 212, 0.75)',
                      backgroundColor: 'rgba(0, 188, 212, 0.3)',
                      pointBorderColor: 'rgba(0, 188, 212, 0)',
                      pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
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
                      ticks:{min:0},
                      scaleLabel:{
                        display:true,
                        labelString:'Pieces'
                      }
                    }],
                    xAxes:[{
                      scaleLabel:{
                        display:true,
                        labelString:'Dates'
                      }
                    }]
                  }
              }
            })





            })
        }
      },
      created(){
        this.fetchFinishing();
      }
    });
  </script>
@endsection
