@extends('layouts.app')

@section('content')
<div class="container" id="app">
  <!--Info Cards-->
  <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="info-box-2 bg-pink">
              <div class="icon">
                  <i class="material-icons">content_cut</i>
              </div>
              <div class="content">
                  <div class="text">CUTTING</div>
                  <div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20">125</div>
              </div>
          </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="info-box-2 bg-green">
              <div class="icon">
                  <i class="fa fa-steam"></i>
              </div>
              <div class="content">
                  <div class="text">SEWING</div>
                  <div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20">125</div>
              </div>
          </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="info-box-2 bg-blue">
              <div class="icon">
                  <i class="material-icons">assignment_turned_in</i>
              </div>
              <div class="content">
                  <div class="text">FINISHING</div>
                  <div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20">125</div>
              </div>
          </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="info-box-2 bg-deep-orange">
              <div class="icon">
                  <i class="fa fa-check-circle"></i>
              </div>
              <div class="content">
                  <div class="text">QUALITY</div>
                  <div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20">125</div>
              </div>
          </div>
      </div>

    </div>
  <!--Info Cards-->
  <div class="row clearfix">
      <!--Cutting Crisp Reports-->
      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
          <div class="card">
              <div class="body bg-pink">
                <div class="m-b--35 font-bold">CUTTING</div>
                  <ul class="dashboard-stat-list">
                      <li>
                          YESTERDAY
                          <span class="pull-right"><b>@{{ psew }}</b> <small>PIECES</small></span>
                      </li>
                      <li>
                          DAILY AVERAGE
                          <span class="pull-right"><b>@{{ cavg }}</b> <small>PIECES</small></span>
                      </li>
                      <li>
                          THIS WEEK
                          <span class="pull-right"><b>@{{ tCut }}</b> <small>PIECES</small></span>
                      </li>
                      <li>
                          CURRENT WIP
                          <span class="pull-right"><b>@{{ cwip }}</b> <small>PIECES</small></span>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <!--Cutting Crisp Reports-->
      <!--Sewing Crisp Reports-->
      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
          <div class="card">
              <div class="body bg-green">
                <div class="m-b--35 font-bold">SEWING</div>
                  <ul class="dashboard-stat-list">
                      <li>
                          YESTERDAY
                          <span class="pull-right"><b>@{{ outcome }}</b> <small>PIECES</small></span>
                      </li>
                      <li>
                          DAILY PRODUCTION RATE
                          <span class="pull-right"><b>@{{ avgProd }}</b> <small>PIECES</small></span>
                      </li>
                      <li>
                          THIS WEEK
                          <span class="pull-right"><b>@{{ tProd }}</b> <small>PIECES</small></span>
                      </li>
                      <li>
                          CURRENT WIP
                          <span class="pull-right"><b>@{{ swip }}</b> <small>PIECES</small></span>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <!--Sewing Crisp Reports-->
      <!--Fining Crisp Reports-->
      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
          <div class="card">
              <div class="body bg-blue">
                <div class="m-b--35 font-bold">FINISHING</div>
                  <ul class="dashboard-stat-list">
                      <li>
                          YESTERDAY
                          <span class="pull-right"><b>@{{ pkd }}</b> <small>PIECES</small></span>
                      </li>
                      <li>
                          DAILY AVERAGE
                          <span class="pull-right"><b>@{{ avgPkd }}</b> <small>PIECES</small></span>
                      </li>
                      <li>
                          THIS WEEK
                          <span class="pull-right"><b>@{{ tPkd }}</b> <small>PIECES</small></span>
                      </li>
                      <li>
                          CURRENT WIP
                          <span class="pull-right"><b>@{{ fwip }}</b> <small>PIECES</small></span>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <!--Fining Crisp Reports-->
      <!--Quality Crisp Reports-->
      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
          <div class="card">
              <div class="body bg-deep-orange">
                <div class="m-b--35 font-bold">QUALITY</div>
                  <ul class="dashboard-stat-list">
                      <li>
                          YESTERDAY DHU
                          <span class="pull-right"><b>@{{ dhu }}</b> <small>%</small></span>
                      </li>
                      <li>
                          AVERAGE DHU
                          <span class="pull-right"><b>@{{ avgDhu }}</b> <small>%</small></span>
                      </li>
                      <li>

                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <!--Quality Crisp Reports-->
  </div>
</div>
@endsection

@section('scripts')
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
        id: 1,
        cwip:0,
        swip:0,
        fwip:0,
        cavg:0,
        savg:0,
        avgDhu:0.0,
        dhu:0.0,
        avgProd:0,
        psew:0,
        outcome: 0,
        tProd:0,
        tCut:0,
        pkd:0,
        tPkd:0,
        avgPkd:0,
        mmr:0
      }
    },
    created(){
      this.fetchReport()
    },
    watch:{

    },
    methods:{
      fetchReport() {
        axios.post(`/admin/factory/reportsmaster/${this.id}`)
        .then((response) => {
          // Filling of the Global Objects for the page and its functions from the fetched data
          this.production = response.data.production
          this.factory.name = response.data.factory[0].name
          this.factory.id = response.data.factory[0].id
          this.cutting = response.data.reports.cutting
          this.sewing = response.data.reports.sewing
          this.finishing = response.data.reports.finishing
          this.quality = response.data.reports.quality
          this.dGeneral = response.data.reports.d_general
          // Variables preprations for the Computing
          this.variablePrep()
        })// Promise function
      },

      variablePrep(){
        // Cutting Variables
        var cwip = [];
        var dates = [];
        var actualC = [];
        var targetC = [];
        var effiCut = [];
        var psew = [];
        // Sewing Variables
        var swip = [];
        var effiSew = [];
        var monthlyProd = [];
        var production = [];
        var months = [];
        // Finishing Variables
        var feed = [];
        var pkd = [];
        var income = [];
        var fwip = [];
        // Quality Variables
        var dhu = [];
        var insp = [];
        var failed = [];
        var passed = [];

        // For initializing the Data objects for the Carts
        var j = 0;
        for(i = this.cutting.length-1; i >= 0; i--){

          dates.push(moment(new Date(this.cutting[i].created_at)).format("D-MMM"));
          actualC.push(this.cutting[i].pcut);
          targetC.push(this.cutting[i].cqty);

          kopr1 = parseInt(this.sewing[i].kopr);
          sopr1 = parseInt(this.sewing[i].sopr);
          sam1  = parseFloat(this.sewing[i].sam);
          prod1 = parseInt(this.sewing[i].prod);
          chkr1 = parseInt(this.sewing[i].chrk);
          hlpr1 = parseInt(this.sewing[i].hlpr);


          effiCut.push(parseFloat((this.cutting[i].pcut / (((kopr1 + sopr1 + chkr1 + hlpr1) * 480) / sam1) * 100).toFixed(2)));
          effiSew.push(parseFloat((((prod1*sam1)/((kopr1 + sopr1 + chkr1 + hlpr1)*480))*100).toFixed(2)));

          production.push(prod);
            if(j == 0){
              cwip.push(this.cutting[i].pcut - this.cutting[i].psew);
              swip.push(this.sewing[i].prod - this.sewing[i].outcome);
              fwip.push(this.finishing[i].income - this.finishing[i].pkd);
            } else {
              cwip.push(this.cutting[i].pcut - this.cutting[i].psew + cwip[j-1]);
              swip.push(this.sewing[i].prod - this.sewing[i].outcome + swip[j-1]);
              fwip.push(this.finishing[i].income - this.finishing[i].pkd + fwip[j-1]);
            }
          j++;
          psew.push(this.cutting[i].psew);
          income.push(this.finishing[i].income);
          pkd.push(this.finishing[i].pkd);
          dhu.push(parseFloat(((this.quality[i].failed/this.quality[i].inspected)*100).toFixed(2)));
          insp.push(this.quality[i].inspected)
          failed.push(this.quality[i].failed)
          passed.push(this.quality[i].inspected - this.quality[i].failed)

        }

        // To fill the Monthly Production Objects for the Charts to Render
        for(i=0; i < this.production.length; i++){
          monthlyProd.push(parseInt(this.production[i].t_prod))
          months.push(moment(this.production[i].month, 'MM').format('MMM'))
        }

        // Average DHU and Yesterday's DHU
            this.dhu = dhu[dhu.length-1];
            var sum = dhu.reduce((a, b) => a + b, 0);
            this.avgDhu = sum/dhu.length


        // AVERAGE CUTTING SEWING AND FINISHING
            // Cutting
            var sum = psew.reduce((a, b) => a + b, 0);
            this.tCut = sum;
            this.cavg = parseInt((sum/psew.length).toFixed(0));
            // Sewing
            var sum = production.reduce((a, b) => a + b, 0);
            this.tProd = sum;
            this.avgProd = parseInt((sum/production.length).toFixed(0));
            // FINISHING
            var sum = pkd.reduce((a, b) => a + b, 0);
            this.tPkd = sum
            this.avgPkd = parseInt((sum/pkd.length).toFixed(0));

        // Yesterday's production
            this.psew = this.cutting[0].psew;
            this.outcome = production[production.length - 1];
            this.pkd = pkd[pkd.length - 1];
        // WIP for All the DEPTS
            this.cwip = cwip[cwip.length -1]
            this.swip = swip[swip.length -1]
            this.fwip = fwip[fwip.length -1]
        // MMR Daily

        // Efficiency of al the DEPT.

        //

      } // Variable Prep Method

    }
  });
</script>
@endsection
