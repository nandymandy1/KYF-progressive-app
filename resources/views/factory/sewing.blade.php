@extends('layouts.app')

@section('content')

<div class="container" id="app">
  @if(Auth::user()->job !='master')
    @if($today)
      <div class="row">
        <div class="col-md-6">
          <a href="/factory/sewinginput" class="btn btn-md btn-primary">Add Today's Data</a>
        </div>
      </div>
    @endif
  @endif
  <br>
  <h2>Sewing Dashboard</h2>
  <div class="row">
    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-blue">
          Target Vs Actual Vs Sent for Washing or Finishing
        </div>
        <div class="card-body">
          <canvas id="divtva" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-red">
          Daily Production
        </div>
        <div class="card-body">
          <canvas id="divdp" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-green">
          Monthly Production
        </div>
        <div class="card-body">
          <canvas id="divmonthly" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-teal">
          Sewing Efficiency
        </div>
        <div class="card-body">
          <canvas id="diveff" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-red">
          Sewing Department WIP
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
          errors:{},
          monthlyProd:{}
        }
      },
      methods:{
        fetchSewing(){
          axios.get(`/reports/sewing/${this.factory_id}`)
          .then(
            (response) => {
              this.report = this.temp = response.data.reports
              this.monthlyProd = response.data.prod
              console.log(this.report);
              var income = [];
              var sopr = [];
              var kopr = [];
              var prod = [];
              var target = [];
              var outcome = [];
              var sam = [];
              var dates = [];
              var eff = [];
              var wip = [];
              var twip = [];
              var month = [];
              var product = [];
              var months = ['','Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];

              for(i = this.report.length -1; i >=0 ; i--){
                dates.push(moment(new Date(this.report[i].created_at)).format("D-MMM"));
                income.push(parseInt(this.report[i].income));
                sopr.push(parseInt(this.report[i].sopr));
                kopr.push(this.report[i].kor);
                prod.push(this.report[i].prod);
                target.push(this.report[i].target);
                outcome.push(this.report[i].outcome);
                sam.push(this.report[i].sam);

                kopr1 = parseInt(this.report[i].kopr);
                sopr1 = parseInt(this.report[i].sopr);
                sam1  = parseFloat(this.report[i].sam);
                prod1 = parseInt(this.report[i].prod);
                chkr1 = parseInt(this.report[i].chrk);
                hlpr1 = parseInt(this.report[i].hlpr);

                eff.push(parseFloat((((prod1*sam1)/((kopr1 + sopr1 + chkr1 + hlpr1)*480))*100).toFixed(2)));

                if(i == this.report.length -1){
                  twip.push(parseInt(this.report[i].prod - this.report[i].outcome));
                } else {
                  twip.push(twip[twip.length -1] + parseInt(this.report[i].prod - this.report[i].outcome));
                }
                wip.push(parseInt(this.report[i].prod - this.report[i].outcome));

              }

              // Monthly Production Report
              for (i = 0; i < this.monthlyProd.length; i++){
                month.push(months[parseInt(this.monthlyProd[i].month)])
                product.push(parseInt(this.monthlyProd[i].tprod))
              }

              var tvaChart = document.getElementById("divtva").getContext('2d');
              var myTva = new Chart(tvaChart, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: "Production",
                        data: prod,
                        borderColor: 'rgba(0, 188, 212, 0.75)',
                        backgroundColor: 'rgba(0, 188, 212, 0.3)',
                        pointBorderColor: 'rgba(0, 188, 212, 0)',
                        pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                        pointBorderWidth: 1
                    }, {
                            label: "Target",
                            data: target,
                            borderColor: 'rgba(233, 30, 99, 0.75)',
                            backgroundColor: 'rgba(233, 30, 99, 0.3)',
                            pointBorderColor: 'rgba(233, 30, 99, 0)',
                            pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                            pointBorderWidth: 1
                        },
                        {
                          label: "Sent for Finishing or Washing",
                          data: outcome,
                          borderColor: 'rgba(34, 153, 84, 0.75)',
                          backgroundColor: 'rgba(82, 190, 128, 0.3)',
                          pointBorderColor: 'rgba(82, 190, 128, 0)',
                          pointBackgroundColor: 'rgba(34, 153, 84, 0.9)',
                          pointBorderWidth: 1
                        }
                      ]
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

              var effChart = document.getElementById("diveff").getContext('2d');
              var myEff = new Chart(effChart, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: "Efficiency",
                        data: eff,
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
                          labelString:'Efficiency%'
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
              })

              var dpChart = document.getElementById("divdp").getContext('2d');
              var myDp = new Chart(dpChart, {
                type: 'bar',
                 data: {
                     labels: dates,
                     datasets: [{
                         label: "Daily Production",
                         data: prod,
                         backgroundColor: 'rgba(160, 150, 212, 0.8)'
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
              })

              var wipChart = document.getElementById("divwip").getContext('2d');
              var myWip = new Chart(wipChart, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                        label: "Daily WIP",
                        data: wip,
                        backgroundColor: 'rgba(0, 188, 212, 0.8)'
                    },{
                      label: "Cumulative WIP",
                      data: twip,
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
              })

              // For monthly Production we have to see this later
              var monthlyChart = document.getElementById("divmonthly").getContext('2d');
              var myMonthly = new Chart(monthlyChart, {
                type: 'bar',
                data: {
                    labels: month,
                    datasets: [{
                        label: "Monthly Production",
                        data: product ,
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
              })

            })
            //.catch((error) => this.errors = error.response.data.errors);
        }

      },
      created(){
        this.fetchSewing();
      }
    });
  </script>

@endsection
