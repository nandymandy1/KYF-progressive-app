@extends('layouts.app')

@section('content')

<div class="container" id="app">
@if(Auth::user()->job != 'master')
  @if($today)
    <div class="row">
      <div class="col-md-6">
        <a href="/factory/cuttinginput" class="btn btn-md btn-primary">Add Today's Data</a>
      </div>
    </div>
  @endif
@endif
  <h2>Cutting Dashboard</h2>
  <div class="row">
    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-red">
          Target Vs Actual
        </div>
        <div class="card-body">
          <canvas id="divtva" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-blue">
          Pieces Sent to Sewing or Embroidery
        </div>
        <div class="card-body">
          <canvas id="divpse" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-green">
          Cutting Department Strength
        </div>
        <div class="card-body">
          <canvas id="divstr" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-light-blue">
          Cutting WIP
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
      return {
        factory_id: {{Auth::user()->factory_id}},
        report:{},
        temp:{},
        errors:{}
      }
    },
    watch:{

    },
    methods:{
      fetchCutting(){
        axios.post(`/reports/cutting/${this.factory_id}`)
        .then(
          (response) => {
            this.report = this.temp = response.data
            var dates = [];
            var cqty = [];
            var psew = [];
            var pemb = [];
            var fout = [];
            var pcut = [];
            var tpeople = [];
            var twip = [];
            var wip = [];

            // to log the report
            for(var i=this.report.length -1; i >=0 ; i--){
              dates.push(moment(new Date(this.report[i].created_at)).format("D-MMM"));
              cqty.push(parseInt(this.report[i].cqty));
              psew.push(parseInt(this.report[i].psew));
              pemb.push(parseInt(this.report[i].pemb));
              fout.push(parseInt(this.report[i].fout));
              pcut.push(parseInt(this.report[i].pcut));
              tpeople.push(parseInt(this.report[i].tpeople));
              wip.push(parseInt(this.report[i].pcut - this.report[i].psew));
              if(i == this.report.length -1){
                twip.push(parseInt(this.report[i].pcut - this.report[i].psew));
              } else {
                twip.push(twip[twip.length -1] + parseInt(this.report[i].pcut - this.report[i].psew));
              }

            }


            // To map the wip
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
                      },
                      gridLines: {
                          color: "rgba(0, 0, 0, 0)",
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

            // To View Target Vs Actual Cutting
            var tvaChart = document.getElementById("divtva").getContext('2d');
            var myTva = new Chart(tvaChart, {
              type: 'line',
              data: {
                  labels: dates,
                  datasets: [{
                      label: "Total Cut Quantity",
                      data: cqty,
                      borderColor: 'rgba(0, 188, 212, 0.75)',
                      backgroundColor: 'rgba(0, 188, 212, 0.3)',
                      pointBorderColor: 'rgba(0, 188, 212, 0)',
                      pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                      pointBorderWidth: 1
                  }, {
                          label: "Pieces Cut",
                          data: pcut,
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
                      },
                      gridLines: {
                          color: "rgba(0, 0, 0, 0)",
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

            var pseChart = document.getElementById("divpse").getContext('2d');
            var myPse = new Chart(pseChart, {
              type: 'bar',
              data: {
                  labels: dates,
                  datasets: [{
                      label: "Pieces Sent for Sewing",
                      data: psew,
                      backgroundColor: 'rgba(0, 188, 212, 0.8)'
                  }, {
                          label: "Pieces Sent for Embroidery",
                          data: pemb,
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
                      },
                      gridLines: {
                          color: "rgba(0, 0, 0, 0)",
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

            var strChart = document.getElementById("divstr").getContext('2d');
            var myStr = new Chart(strChart, {
              type: 'line',
              data: {
                  labels: dates,
                  datasets: [{
                      label: "Cutting Department Strength",
                      data: tpeople,
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
                      },
                      gridLines: {
                          color: "rgba(0, 0, 0, 0)",
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

          })
        // .catch((error) => this.errors = error.response.data.errors)
      }

    },
    created(){
      this.fetchCutting()
    }
  });

  </script>

@endsection
