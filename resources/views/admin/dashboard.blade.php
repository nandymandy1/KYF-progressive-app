@extends('layouts.app') @section('content')
<div class="container" id="app">
  <h4>@{{ factory.name }}</h4>
  <div class="card">
    <div class="card-header bg-red">
        Cutting
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="" id="ceffi"></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="" id="tvac"></div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="" id="cwip"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header bg-light-blue">
      Sewing
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="" id="seffi"></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="" id="mp"></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="" id="dp"></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="" id="swip"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header bg-green">
      Finishing
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="" id="fwip"></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="" id="fedvpkd"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header bg-light-blue">
      Quality
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="" id="dhu"></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="" id="invfa"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--<div class="card">
    <div class="card-header bg-teal">
      General
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">

            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">

            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>-->
</div>
@endsection @section('scripts')
  <script src="{{ asset('./js/highcharts.src.js')}}" charset="utf-8"></script>
  <script src="{{ asset('./js/moment.js')}}" charset="utf-8"></script>

<script type="text/javascript">
  var app = new Vue({
    el: '#app',
    data(){
      return{
        factory: {
          name: '',
          id: ''
        },
        cutting: {},
        sewing: {},
        finishing: {},
        quality: {},
        dGeneral: {},
        temp: {},
        errors: {},
        production:{},
        id: {{$req}}
      }
    },

    created(){
      this.fetchReport()
    },

    methods:{
      fetchReport() {
        axios.post(`/admin/factory/reports/${this.id}`)
        .then((response) => {
          this.production = response.data.production
          this.factory.name = response.data.factory[0].name
          this.factory.id = response.data.factory[0].id
          this.cutting = response.data.reports.cutting
          this.sewing = response.data.reports.sewing
          this.finishing = response.data.reports.finishing
          this.quality = response.data.reports.quality
          this.dGeneral = response.data.reports.d_general

          // Cutting Variables
          var cwip = [];
          var datesC = [];
          var actualC = [];
          var targetC = [];
          var effiCut1 = [];
          // Sewing Variables
          var datesS = [];
          var swip = [];
          var effiSew = [];
          var monthlyProd = [];
          var production = [];
          var months = [];
          var kopr1 = [];
          var sam1 = [];
          var sopr1 = [];
          // Finishing Variables
          var datesF = [];
          var feed = [];
          var pkd = [];
          var income = [];
          var fwip = [];
          // Quality Variables
          var datesQ = [];
          var dhu = [];
          var insp = [];
          var failed = [];
          var passed = [];
          var hlpr = [];
          var chkr = [];
          // Cumulative WIP
          dcutWip = [];
          dsewWip = [];
          dfinWip = [];
          // General Data Variables


          // For initializing the Cutting Data objects

          var j = 0;
          for(i = this.cutting.length-1; i >= 0; i--){

            datesC.push(moment(new Date(this.cutting[i].created_at)).format("D-MMM"));
            actualC.push(parseInt(this.cutting[i].pcut));
            targetC.push(parseInt(this.cutting[i].cqty));
            if(j == 0){
                cwip.push(this.cutting[i].pcut - this.cutting[i].psew);
              } else {
                cwip.push(this.cutting[i].pcut - this.cutting[i].psew + cwip[j-1]);
              }
            j++;
            dcutWip.push(this.cutting[i].pcut - this.cutting[i].psew);
          }

          // To fill Sewing data
          var j = 0;
          for(i = this.sewing.length-1; i >= 0; i--){
            datesS.push(moment(new Date(this.sewing[i].created_at)).format("D-MMM"));

            kopr = parseInt(this.sewing[i].kopr);
            sopr = parseInt(this.sewing[i].sopr);
            sam  = parseFloat(this.sewing[i].sam);
            prod1 = parseInt(this.sewing[i].prod);
            chkr1 = parseInt(this.sewing[i].chrk);
            hlpr1 = parseInt(this.sewing[i].hlpr);

            kopr1.push(kopr);
            chkr.push(chkr1);
            hlpr.push(hlpr1);
            sopr1.push(sopr);
            sam1.push(sam);
            effiSew.push(parseFloat((((prod1*sam)/((kopr + sopr + chkr1 + hlpr1)*480))*100).toFixed(2)));
            production.push(prod1);

            if(j == 0){
              swip.push(this.sewing[i].prod - this.sewing[i].outcome);
            } else {
              swip.push(this.sewing[i].prod - this.sewing[i].outcome + swip[j-1]);
            }
            j++;
            dsewWip.push(this.sewing[i].prod - this.sewing[i].outcome);
          }


          // To get the Cutting Efficiency
          var a = Math.min(this.cutting.length, this.sewing.length)
          for(i = 0; i < a; i++){
            effiCut1.push(((actualC[i]/(((kopr1[i]+sopr1[i] + hlpr[i] + chkr[i])*480)/sam1[i]))*100).toFixed(2));
          }

          var effiCut = [];
          effiCut1.forEach((eff) => {
             effiCut.push(parseFloat(eff));
           });


          //To fill Finishing data
          var j = 0;
          for(i = this.finishing.length-1; i >= 0; i--){
            datesF.push(moment(new Date(this.finishing[i].created_at)).format("D-MMM"));
            if(j == 0){
              fwip.push(this.finishing[i].income - this.finishing[i].pkd);
            } else {
              fwip.push(this.finishing[i].income - this.finishing[i].pkd + fwip[j-1]);
            }
            j++;
            dfinWip.push(this.finishing[i].income - this.finishing[i].pkd);
            income.push(parseInt(this.finishing[i].income));
            pkd.push(parseInt(this.finishing[i].pkd));
          }

          // To fill Quality Data
          for(i = this.quality.length-1; i >= 0; i--){
            datesQ.push(moment(new Date(this.quality[i].created_at)).format("D-MMM"));
            dhu.push(parseFloat(((this.quality[i].failed/this.quality[i].inspected)*100).toFixed(2)));
            insp.push(parseInt(this.quality[i].inspected))
            failed.push(parseInt(this.quality[i].failed))
            passed.push(parseInt(this.quality[i].inspected - this.quality[i].failed))

          }

          // To fill the Monthly Production Objects for the Charts to Render
          var month = [];
          var product = [];
          var months = ['','Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];

          for (i = 0; i < this.production.length; i++){
            month.push(months[parseInt(this.production[i].month)])
            product.push(parseInt(this.production[i].tprod))
          }

          // Cutting WIP
          var cwip = Highcharts.chart('cwip', {
              title: {
                  text: 'Cutting WIP'
              },
              subtitle: {
                  text: 'WIP'
              },
              xAxis: {
                  categories: datesC
              },
              yAxis: {
                  title: {
                      text: 'Number of Pieces'
                  }
              },
              plotOptions: {
                  line: {
                      dataLabels: {
                          enabled: true
                      },
                      enableMouseTracking: true
                  }
              },
              series: [{
                  type: 'column',
                  name: 'Daily Cumulative WIP',
                  colorByPoint: true,
                  data: cwip,
                  showInLegend: false
              },{
                  type: 'column',
                  name: 'Daily Cutting WIP',
                  colorByPoint: true,
                  data: dcutWip,
                  showInLegend: false
              }]
          });
          // Cutting WIP

          // Cutting Target Vs Actual
          var tvac = Highcharts.chart('tvac', {
              chart: {
                  type: 'line'
              },
              title: {
                  text: 'Target Vs Actual'
              },
              subtitle: {
                  text: 'Target vs Actual Cutting Quantity'
              },
              xAxis: {
                  categories: datesC
              },
              yAxis: {
                  title: {
                      text: 'Number of Pieces'
                  }
              },
              plotOptions: {
                  line: {
                      dataLabels: {
                          enabled: true
                      },
                      enableMouseTracking: true

                  }
              },
              series: [{
                  name: 'Actual',
                  data: actualC
              }, {
                  name: 'Target',
                  data: targetC
              }]
          });
          // Cutting target Vs Actual

          // Cutting Efficiency

          var ceffi = Highcharts.chart('ceffi', {
              chart: {
                  type: 'line'
              },
              title: {
                  text: 'Efficiency'
              },
              subtitle: {
                  text: 'Cutting Efficiency w.r.t Sewing'
              },
              xAxis: {
                  categories: datesC
              },
              yAxis: {
                  title: {
                      text: 'Efficiency(%)'
                  }
              },
              plotOptions: {
                  line: {
                      dataLabels: {
                          enabled: true
                      },
                      enableMouseTracking: true
                  }
              },
              series: [{
                  name: 'Efficiency',
                  data: effiCut
              }]
          });

          // Cutting Efficiency

          // Sewing Efficiency
          var seffi = Highcharts.chart('seffi', {
              chart: {
                  type: 'line'
              },
              title: {
                  text: 'Efficiency'
              },
              subtitle: {
                  text: 'Sewing Efficiency'
              },
              xAxis: {
                  categories: datesS
              },
              yAxis: {
                  title: {
                      text: 'Efficiency(%)'
                  }
              },
              plotOptions: {
                  line: {
                      dataLabels: {
                          enabled: true
                      },
                      enableMouseTracking: true
                  }
              },
              series: [{
                  name: 'Efficiency',
                  data: effiSew
              }]
          });
          // Sewing Efficiency

          // Monthly production
          var mp = Highcharts.chart('mp', {
              title: {
                  text: 'Monthly Production'
              },
              xAxis: {
                  categories: month
              },
              yAxis: {
                  title: {
                      text: 'Pieces Produced'
                  }
              },
              plotOptions: {
                  line: {
                      dataLabels: {
                          enabled: true
                      },
                      enableMouseTracking: true
                  }
              },
              series: [{
                  type: 'column',
                  name: 'Pieces Produced',
                  colorByPoint: true,
                  data: product,
                  showInLegend: false
              }]
          });
          // Monthly Production

          // Daily production
          var dp = Highcharts.chart('dp', {
              title: {
                  text: 'Daily Production'
              },
              xAxis: {
                  categories: datesS
              },
              yAxis: {
                  title: {
                      text: 'Pieces Produced'
                  }
              },
              plotOptions: {
                  line: {
                      dataLabels: {
                          enabled: true
                      },
                      enableMouseTracking: true
                  }
              },
              series: [{
                  type: 'column',
                  name: 'Pieces Produced',
                  colorByPoint: true,
                  data: production,
                  showInLegend: false
              }]
          });
          // Daily Production

          // Daily Sewing WIP
          var swip = Highcharts.chart('swip', {
              title: {
                  text: 'Sewing WIP'
              },
              subtitle: {
                  text: 'WIP'
              },
              xAxis: {
                  categories: datesS
              },
              yAxis: {
                  title: {
                      text: 'Number of Pieces'
                  }
              },
              plotOptions: {
                  line: {
                      dataLabels: {
                          enabled: true
                      },
                      enableMouseTracking: true
                  }
              },
              series: [{
                  type: 'column',
                  name: 'Daily Cumulative WIP',
                  colorByPoint: true,
                  data: swip,
                  showInLegend: false
              },{
                  type: 'column',
                  name: 'Daily Sewing WIP',
                  colorByPoint: true,
                  data: dsewWip,
                  showInLegend: false
              }]
          });
          // Daily Sewing WIP

          // Finishing wip
          var fwip = Highcharts.chart('fwip', {
              title: {
                  text: 'Finishing WIP'
              },
              xAxis: {
                  categories: datesF
              },
              yAxis: {
                  title: {
                      text: 'Pieces'
                  }
              },
              plotOptions: {
                  line: {
                      dataLabels: {
                          enabled: true
                      },
                      enableMouseTracking: true
                  }
              },
              series: [{
                  type: 'column',
                  colorByPoint: true,
                  name: 'Daily Cumulative WIP',
                  data: fwip,
                  showInLegend: false
              },{
                  type: 'column',
                  name: 'Daily Finishing WIP',
                  colorByPoint: true,
                  data: dfinWip,
                  showInLegend: false
              }]
          });
          // Finishing wip

          // Finishing Income vs Finished Goods
          var fedvpkd = Highcharts.chart('fedvpkd', {
              chart: {
                  type: 'line'
              },
              title: {
                  text: 'Finishing Income vs Finished Goods'
              },
              subtitle: {
                  text: 'Pieces Fed into finishig and Packed Goods'
              },
              xAxis: {
                  categories: datesF
              },
              yAxis: {
                  title: {
                      text: 'Number of Pieces'
                  }
              },
              plotOptions: {
                  line: {
                      dataLabels: {
                          enabled: true
                      },
                      enableMouseTracking: true


                  }
              },
              series: [{
                  name: 'Packed Goods',
                  data: pkd
              }, {
                  name: 'Fed into Finishing',
                  data: income
              }]
          });

          // Finishing Income vs Finished Goods

          // DHU
          var dhuchart = Highcharts.chart('dhu', {
              chart: {
                  type: 'line'
              },
              title: {
                  text: 'DHU'
              },
              subtitle: {
                  text: 'Daily DHU Report'
              },
              xAxis: {
                  categories: datesQ
              },
              yAxis: {
                  title: {
                      text: 'DHU(%)'
                  }
              },
              plotOptions: {
                  line: {
                      dataLabels: {
                          enabled: true
                      },
                      enableMouseTracking: true
                  }
              },
              series: [{
                  name: 'DHU',
                  data: dhu
              }]
          });
          // DHU

          // Failed vs passed
          var invfa = Highcharts.chart('invfa', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Failed Vs Passed'
                },
                xAxis: {
                    categories: datesQ
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total Inspected Quantity'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        }
                    }
                },
                legend: {
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                        }
                    }
                },
                series: [{
                    name: 'Failed Quantity',
                    data: failed
                }, {
                    name: 'Passed Quantity',
                    data: passed
                }]
          });
          // Failed vs passed

        })// Promise function
      }
    }

  });
</script>
@endsection
