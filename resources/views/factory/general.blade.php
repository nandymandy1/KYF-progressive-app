@extends('layouts.app')

@section('content')

<div class="container">
  @if (Auth::user()->job != 'master')
    @if($today)
      <div class="row">
        <div class="col-md-6">
          <a href="/factory/generalinput" class="btn btn-md btn-primary">Add Today's Data</a>
        </div>
      </div>
    @endif
  @endif
  <br>
  <h2>General Dashboard</h2>
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header bg-red">
          Total Overtime in Cutting
        </div>
        <div class="card-body">
          <h4 id="ovt_cut">@{{ ovt_cut }} hrs</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header bg-blue">
          Total Overtime in Sewing
        </div>
        <div class="card-body">
          <h4 id="ovt_sew">@{{ ovt_sew }} hrs</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header bg-green">
          Total Overtime in Finishing
        </div>
        <div class="card-body">
          <h4 id="ovt_fin">@{{ ovt_fin }} hrs</h4>
        </div>
      </div>
      </div>
  </div>
  <div class="row">
    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-blue">
          Total Overtime
        </div>
        <div class="card-body">
          <canvas id="overtime_Tot" height="150"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-indigo">
          Overtime In Cutting Department
        </div>
        <div class="card-body">
          <canvas id="overtime_cut" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-blue">
          Overtime In Sewing Department
        </div>
        <div class="card-body">
          <canvas id="overtime_sew" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-blue">
          Overtime In Finishing Department
        </div>
        <div class="card-body">
          <canvas id="overtime_fin" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-red">
          Absenteeism
        </div>
        <div class="card-body">
          <canvas id="abs" height="150"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header bg-light-green">
          Man Machine Ratio
        </div>
        <div class="card-body">
          <canvas id="mmr" height="150"></canvas>
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
          mmr:{},
          temp:{},
          errors:{},
          ovt_sew:0,
          ovt_cut:0,
          ovt_fin:0
        }
      },
      methods:{
        fetchReports(){
          axios.get(`/reports/general/${this.factory_id}`)
          .then(
            (response) => {
              this.report = this.temp = response.data.reports
              this.mmr = response.data.mmr
              osew = [];
              ofin = [];
              ocut = [];
              dates = [];
              absr = [];
              payrole = [];
              ppeople = [];
              twf = [];
              sopr = [];
              tot_ov = [];
              kopr = [];
              mmratio = [];
              for(i = this.report.length -1; i >=0 ; i--){
                dates.push(moment(new Date(this.report[i].created_at)).format("D-MMM"));
                osew.push(parseFloat(this.report[i].osew));
                ofin.push(parseFloat(this.report[i].ofin));
                this.ovt_sew += parseFloat(this.report[i].osew);
                this.ovt_fin += parseFloat(this.report[i].ofin);
                this.ovt_cut += parseFloat(this.report[i].ocut);
                ocut.push(parseFloat(this.report[i].ocut));
                abs = parseInt(this.report[i].abs);
                twf1 = parseInt(this.report[i].twf);
                arate = ((abs/twf1)*100).toFixed(2);
                absr.push(arate)
                twf.push(parseInt(this.report[i].twf))
                payrole.push(parseFloat(this.report[i].payrole));
                ppeople.push(parseFloat(this.report[i].ppeople));
                tot_ov.push((parseFloat(this.report[i].ocut) + parseFloat(this.report[i].ofin) + parseFloat(this.report[i].osew)).toFixed(2));
              }

              for(i = this.mmr.length -1; i >=0 ; i--){
                sopr.push(parseInt(this.mmr[i].kopr));
                kopr.push(parseInt(this.mmr[i].sopr));
              }
              for(i = 0; i < sopr.length; i++){
                mmratio.push((twf[i]/(sopr[i]+kopr[i])).toFixed(2));
              }

              var mmrChart = document.getElementById("mmr").getContext('2d');
              var myMmr = new Chart(mmrChart, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: "Man Machine Ratio",
                        data: mmratio,
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
                          labelString:'MMR'
                        }
                      }]
                    }
                }
              });

              var absChart = document.getElementById("abs").getContext('2d');
              var myAbs = new Chart(absChart, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: "Absentism",
                        data: absr,
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
                          labelString:'Absenteeism%'
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

              var overCut = document.getElementById("overtime_cut").getContext('2d');
              var myCut = new Chart(overCut, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                        label: "Cutting",
                        data: ocut,
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
                          labelString:'Overtime in Hrs.'
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

              var overSew = document.getElementById("overtime_sew").getContext('2d');
              var mySew = new Chart(overSew, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                            label: "Sewing",
                            data: osew,
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
                          labelString:'Overtime in Hrs.'
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

              var overFin = document.getElementById("overtime_fin").getContext('2d');
              var myFin = new Chart(overFin, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                          label: "Finishing",
                          data: ofin,
                          borderColor: 'rgba(52, 152, 219, 0.75)',
                          backgroundColor: 'rgba(93, 173, 226, 0.3)',
                          pointBorderColor: 'rgba(93, 173, 226, 0)',
                          pointBackgroundColor: 'rgba(93, 173, 226, 0.9)',
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
                          labelString:'Overtime in Hrs.'
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

              var overTot = document.getElementById("overtime_Tot").getContext('2d');
              var myTot = new Chart(overTot, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                          label: "Total Overtime",
                          data: tot_ov,
                          borderColor: 'rgba(52, 152, 219, 0.75)',
                          backgroundColor: 'rgba(99, 173, 200, 0.3)',
                          pointBorderColor: 'rgba(99, 173, 250, 0)',
                          pointBackgroundColor: 'rgba(99, 200, 226, 0.9)',
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
                          labelString:'Overtime in Hrs.'
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

            });
        }
      },
      created(){
        this.fetchReports();
      }
    });
  </script>
@endsection
