@extends('layouts.app')

@section('content')

<div class="container">
  @if(Auth::user()->job !='master')
    @if($today)
      <div class="row">
        <div class="col-md-6">
          <a href="/factory/qualityinput" class="btn btn-md btn-primary">Add Today's Data</a>
        </div>
      </div>
    @endif
  @endif
  <br>
  <h2>Quality Dashboard</h2>
  <div class="row">
    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-blue">
          Daily DHU
        </div>
        <div class="card-body">
          <canvas id="divdhu" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-red">
          Inspected Vs Failed
        </div>
        <div class="card-body">
          <canvas id="divfvi" height="150"></canvas>
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
        return {
          factory_id: {{Auth::user()->factory_id}},
          report:{},
          temp:{},
          errors:{}
        }
      },
      methods:{
        fetchQuality(){
          axios.post(`/reports/quality/${this.factory_id}`)
          .then(
              (response) => {
                this.report = this.temp = response.data
                console.log(this.report);
                var inspected = [];
                var failed = [];
                var dates = [];
                var dhu = [];
                for(i = this.report.length -1; i >=0 ; i--){
                  dates.push(moment(new Date(this.report[i].created_at)).format("D-MMM"));
                  inspected.push(parseInt(this.report[i].inspected));
                  failed.push(parseInt(this.report[i].failed));
                  var nr = parseInt(this.report[i].failed);
                  var dr = parseInt(this.report[i].inspected);
                  dhu.push(((nr/dr)*100).toFixed(2));
                }
                console.log(dhu);

                var dhuChart = document.getElementById("divdhu").getContext('2d');
                var myDhu = new Chart(dhuChart, {
                  type: 'line',
                  data: {
                      labels: dates,
                      datasets: [{
                          label: "DHU",
                          data: dhu,
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
                            labelString:'DHU%'
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

                var fviChart = document.getElementById("divfvi").getContext('2d');
                var fvi = new Chart(fviChart, {
                  type: 'bar',
                  data: {
                      labels: dates,
                      datasets: [{
                          label: "Inspected Quantity",
                          data: inspected,
                          backgroundColor: 'rgba(0, 188, 212, 0.8)'
                      }, {
                              label: "Failed Quantity",
                              data: failed,
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


              })
        }
      },
      created(){
        this.fetchQuality();
      }
    })
  </script>

@endsection
