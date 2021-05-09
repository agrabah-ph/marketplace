import { Component, OnInit } from '@angular/core';
import { map } from 'rxjs/operators';
import { Breakpoints, BreakpointObserver } from '@angular/cdk/layout';
import { AuthenticationService } from 'src/app/services/authentication.service';

import { Farmer,FarmerWithRelations } from 'src/app/api/models';
import { FarmerControllerService } from 'src/app/api/services/farmer-controller.service';

import highchartsTreemap from 'highcharts/modules/treemap';
import highchartsHeatmap from 'highcharts/modules/heatmap';

import * as Highcharts from 'highcharts';
highchartsTreemap(Highcharts);
highchartsHeatmap(Highcharts);


@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  /** Based on the screen size, switch from standard to one column per row */
  cards = this.breakpointObserver.observe(Breakpoints.Handset).pipe(
    map(({ matches }) => {
      if (matches) {
        return [
          { title: '', cols: 1, rows: 1 },
          { title: '', cols: 1, rows: 1 },
          { title: '', cols: 1, rows: 1 },
          { title: '', cols: 1, rows: 1 }
        ];
      }

      return [
        { title: '', cols: 2, rows: 1 },
        { title: '', cols: 1, rows: 1 },
        { title: '', cols: 1, rows: 2 },
        { title: '', cols: 1, rows: 1 }
      ];
    })
  );

  Highcharts: typeof Highcharts = Highcharts; // required
  chartConstructor: string = 'chart'; // optional string, defaults to 'chart'
  chartOptions: Highcharts.Options = { 
    colorAxis: {
    minColor: '#FFFFFF',
    maxColor: '#AA00FF'
    },
    credits: {
      enabled: false
    },
    series: [{
      type: "treemap",
      layoutAlgorithm: 'squarified',
      
          animationLimit: 1000,
          dataLabels: {
              enabled: false
          },
          levelIsConstant: false,
          levels: [{
              level: 1,
              dataLabels: {
                  enabled: true
              },
              borderWidth: 3
          }],
      data: [
      {"id":"1","name":"KM 9 ZONE 1","parent":"0", "colorValue": 4},
{"id":"2","name":"ZONE 2 KM 9","parent":"0"},
{"id":"3","name":"BLOCK 14 LOT 20 GREENVALLEY SUBDIVISION","parent":"0"},
{"id":"4","name":"KM 9 ZONE 1","parent":"0"},
{"id":"5","name":"ZONE 1 SITIO CAMBA","parent":"0"},
{"id":"6","name":"ZONE 1 LOWER A URBAN POOR","parent":"0"},
{"id":"7","name":"ZONE 7 SITIO TIRIPON","parent":"0"},
{"id":"8","name":"ZONE 6","parent":"0"},
{"id":"9","name":"BLOCK 42 LOT 10 GREENVALLEY SUBD.","parent":"0"},
{"id":"10","name":"ZONE 1 KM 10","parent":"0"},
{"id":"11","name":"DALANDAN ST. GREENVALLEY SUBDIVISION","parent":"0"},
{"id":"12","name":"BLOCK 07 LOT 14 MADRIGAL HOUSING","parent":"0"},
{"id":"13","name":"ZONE 6A","parent":"0"},
{"id":"14","name":"LOWER A URBAN POOR","parent":"0"},
{"id":"15","name":"ZONE 1 KM 11","parent":"0"},
{"id":"16","name":"BLOCK 7 LOT 32 CACERES HEIGHTS RESORT SUBDIVISION","parent":"0"},
{"id":"17","name":"BLOCK 56 LOT 3 GREENVALLEY SUBDIVISION","parent":"0"},
{"id":"18","name":"BLOCK 14 LOT 21 ZONE GREEN VALLEY SUBDIVISION","parent":"0"},
{"id":"19","name":"KM 9 ZONE 1 SITIO CAMBA","parent":"0"},
{"id":"20","name":"BLOCK 17 LOT 32 GREENVILLE SUBDIVISION","parent":"0"},
{"id":"21","name":"BLOCK 31 LOT 9 GREENVILLE SUBDIVISION","parent":"0"},
{"id":"22","name":"BLOCK 36 LOT 8 GREENVILLE SUBDIVISION","parent":"0"},
{"id":"23","name":"BLOCK 54 LOT 1 GREENVILLE SUBDIVISION","parent":"0"},
{"id":"24","name":"JUAN MUSTERA","value":0.05,"colorValue":21,"parent":"1"},
{"id":"25","name":"ROMEO DELA CRUZ","value":0.05,"colorValue":21,"parent":"2"},
{"id":"26","name":"LENY EMPOY","value":0.06,"colorValue":19,"parent":"3"},
{"id":"27","name":"SAMSON MENDOZA","value":0.1,"colorValue":4,"parent":"1"},
{"id":"28","name":"JEFFREY MUSTERA","value":0.15,"colorValue":11,"parent":"5"},
{"id":"29","name":"JOEL LONCERAS","value":0.05,"colorValue":17,"parent":"6"},
{"id":"30","name":"ROSAURO ABRAZADO","value":0.02,"colorValue":21,"parent":"1"},
{"id":"31","name":"MARIA JACOBE CHAVENIA","value":0.05,"colorValue":4,"parent":"7"},
{"id":"32","name":"NORAIDA MROR","value":0.06,"colorValue":26,"parent":"8"},
{"id":"33","name":"REMEDIOS ENRIQUEZ","value":0.15,"colorValue":31,"parent":"1"},
{"id":"34","name":"LETECIA GASGA","value":0.04,"colorValue":16,"parent":"1"},
{"id":"35","name":"FERNAN GAMBOA","value":0.02,"colorValue":9,"parent":"8"},
{"id":"36","name":"CESAR GAMBOA","value":0.03,"colorValue":6,"parent":"8"},
{"id":"37","name":"ROGER FUENTEBELLA","value":0.05,"colorValue":6,"parent":"1"},
{"id":"38","name":"FLORINDA PASTRANA","value":0.05,"colorValue":4,"parent":"6"},
{"id":"39","name":"NICOLAS OCAMPENA","value":0.02,"colorValue":13,"parent":"1"},
{"id":"40","name":"EMMA CAMBA","value":0.03,"colorValue":30,"parent":"9"},
{"id":"41","name":"MA. DELIA BANOG","value":0.08,"colorValue":40,"parent":"1"},
{"id":"42","name":"DEVINA OCAMPINA","value":0.05,"colorValue":32,"parent":"1"},
{"id":"43","name":"JOEL MILLARES","value":1,"colorValue":11,"parent":"10"},
{"id":"44","name":"MARICEL NAVARRO","value":0.03,"colorValue":3,"parent":"5"},
{"id":"45","name":"MARY GRACE MUSTERA","value":0.03,"colorValue":8,"parent":"5"},
{"id":"46","name":"ADELINA ABARIENTOS","value":0.03,"colorValue":21,"parent":"1"},
{"id":"47","name":"EMERLINA RECONDAY","value":0.05,"colorValue":31,"parent":"1"},
{"id":"48","name":"DIOSDADO ADOR","value":0.05,"colorValue":16,"parent":"1"},
{"id":"49","name":"CRESENCIO RIVERO","value":0.1,"colorValue":21,"parent":"11"},
{"id":"50","name":"ROLLIE MUNDA","value":0.1,"colorValue":16,"parent":"1"},
{"id":"51","name":"ROMA RUCINAS","value":0.25,"colorValue":22,"parent":"1"},
{"id":"52","name":"JOSEPHINE EXPECTACION","value":0.2,"colorValue":22,"parent":"12"},
{"id":"53","name":"MICHAEL MUSTERA","value":0.05,"colorValue":21,"parent":"2"},
{"id":"54","name":"NOEL MUSTERA","value":0.15,"colorValue":15,"parent":"2"},
{"id":"55","name":"DARWIN MUSTERA","value":0.05,"colorValue":12,"parent":"2"},
{"id":"56","name":"CECILE MUSTERA","value":0.05,"colorValue":9,"parent":"2"},
{"id":"57","name":"ALFREDO MACASINAG","value":0.08,"colorValue":21,"parent":"1"},
{"id":"58","name":"RAUL VICENTE","value":0.03,"colorValue":17,"parent":"1"},
{"id":"59","name":"ELENA VICENTE","value":0.1,"colorValue":40,"parent":"1"},
{"id":"60","name":"RENE VICENTE","value":0.03,"colorValue":11,"parent":"1"},
{"id":"61","name":"BENJAMEN VICENTE","value":0.03,"colorValue":18,"parent":"1"},
{"id":"62","name":"HERMOSO ULAN","value":0.02,"colorValue":18,"parent":"13"},
{"id":"63","name":"MARIA TESSIE LOZADA","value":0.05,"colorValue":19,"parent":"14"},
{"id":"64","name":"ADELAIDA FERNANDEZ","value":0.25,"colorValue":20,"parent":"15"},
{"id":"65","name":"MARIVIC HERMOSA","value":0.2,"colorValue":7,"parent":"15"},
{"id":"66","name":"PRINCESITA OCBIAN","value":0.5,"colorValue":16,"parent":"15"},
{"id":"67","name":"SALVACION PEREZ","value":0.2,"colorValue":11,"parent":"10"},
{"id":"68","name":"NELLY RESARE","value":0.2,"colorValue":32,"parent":"1"},
{"id":"69","name":"DINA QUIJANO","value":0.25,"colorValue":31,"parent":"1"},
{"id":"70","name":"MANUEL LACIBAL","value":0.05,"colorValue":6,"parent":"1"},
{"id":"71","name":"LYDIA ULAN","value":0.2,"colorValue":31,"parent":"1"},
{"id":"72","name":"ELVIE TEDERA","value":0.05,"colorValue":21,"parent":"10"},
{"id":"73","name":"ZYRENE TEDERA","value":0.05,"colorValue":7,"parent":"10"},
{"id":"74","name":"REYNALDO AVENIDO","value":0.15,"colorValue":36,"parent":"10"},
{"id":"75","name":"REZIE BORNOLLA","value":0.02,"colorValue":7,"parent":"10"},
{"id":"76","name":"FIDELA LAGOS","value":0.1,"colorValue":51,"parent":"1"},
{"id":"77","name":"ROMEO CALINGACION","value":0.2,"colorValue":7,"parent":"16"},
{"id":"78","name":"VICTORIA NAMORA","value":0.01,"colorValue":25,"parent":"8"},
{"id":"79","name":"LORNA BARON","value":0.05,"colorValue":11,"parent":"17"},
{"id":"80","name":"LENY BERLON","value":0.06,"colorValue":19,"parent":"18"},
{"id":"81","name":"MARY ROSE BASOG","value":0.07,"colorValue":14,"parent":"5"},
{"id":"82","name":"JOSEFINA ARCEGA","value":0.05,"colorValue":41,"parent":"1"},
{"id":"83","name":"JOVEN ARCEGA","value":0.05,"colorValue":9,"parent":"1"},
{"id":"84","name":"JESUS MACASINAG","value":0.05,"colorValue":13,"parent":"5"},
{"id":"85","name":"LOURDES MILLARES","value":0.03,"colorValue":16,"parent":"5"},
{"id":"86","name":"JOSE BOROLAGATAN","value":0.03,"colorValue":16,"parent":"5"},
{"id":"87","name":"JESUS BORLAGATAN","value":0.03,"colorValue":16,"parent":"5"},
{"id":"88","name":"ANTONIO ESTEFANI","value":0.03,"colorValue":16,"parent":"19"},
{"id":"89","name":"JONATHAN MACASINAG","value":0.03,"colorValue":15,"parent":"19"},
{"id":"90","name":"ERLINDA AMISOLA","value":0.08,"colorValue":8,"parent":"1"},
{"id":"91","name":"ERLINDA MACASINAG","value":0.03,"colorValue":21,"parent":"1"},
{"id":"92","name":"FIDELA LAGOS","value":0.1,"colorValue":51,"parent":"1"},
{"id":"93","name":"JOCELYN GUERRERO","value":0.05,"colorValue":9,"parent":"1"},
{"id":"94","name":"MERCY BANOG","value":0.07,"colorValue":12,"parent":"1"},
{"id":"95","name":"EDWINA BANOG","value":0.05,"colorValue":8,"parent":"1"},
{"id":"96","name":"TEOPISTO GALVAN","value":0.15,"colorValue":25,"parent":"20"},
{"id":"97","name":"ALFIE SALVADOR","value":0.05,"colorValue":24,"parent":"21"},
{"id":"98","name":"ALFRED SALVADOR","value":0.05,"colorValue":22,"parent":"22"},
{"id":"99","name":"FERDINAND ADOR","value":0.3,"colorValue":31,"parent":"23"},
{"id":"100","name":"MARITA OCAMPINA","value":0.02,"colorValue":31,"parent":"1"},
{"id":"101","name":"EDGEL REFE","value":0.03,"colorValue":6,"parent":"5"},
{"id":"102","name":"RUBEN ABORQUEZ","value":0.02,"colorValue":26,"parent":"5"},
{"id":"103","name":"ROLLY ABADESA","value":0.14,"colorValue":11,"parent":"1"},
{"id":"104","name":"ESTELA REPATACODO","value":0.2,"colorValue":21,"parent":"1"},
{"id":"105","name":"VERCITA CAMBA","value":0.2,"colorValue":11,"parent":"1"},
{"id":"106","name":"JONEL BRONDIAL","value":0.08,"colorValue":5,"parent":"1"},
{"id":"107","name":"MARIANO SALVADOR","value":0.15,"colorValue":22,"parent":"1"},
{"id":"108","name":"LUCILA ADOR","value":0.2,"colorValue":14,"parent":"1"},
{"id":"109","name":"MARGARITA GERALDE","value":0.15,"colorValue":9,"parent":"1"},
{"id":"110","name":"JULITA CAPISTRANO","value":0.2,"colorValue":6,"parent":"1"},
{"id":"111","name":"MARITES CABRERA","value":0.1,"colorValue":13,"parent":"1"},
{"id":"112","name":"ROSALDO ADOR","value":0.2,"colorValue":31,"parent":"1"},
{"id":"113","name":"JOVITO ADOR","value":0.2,"colorValue":31,"parent":"1"},
{"id":"114","name":"DIOSDADO ADOR","value":0.2,"colorValue":21,"parent":"1"}      
      
      ]
  }],
  title: {
      text: 'PACOL CUT FLOWERS'
  } }; // required
  chartCallback: Highcharts.ChartCallbackFunction = function (chart) {  } // optional function, defaults to null
  updateFlag: boolean = false; // optional boolean
  oneToOneFlag: boolean = true; // optional boolean, defaults to false
  runOutsideAngularFlag: boolean = false; // optional boolean, defaults to false

 

  constructor(private breakpointObserver: BreakpointObserver,
    public authService: AuthenticationService,
    private farmerService: FarmerControllerService) {
    
    }


  isLoggedIn() {
    return this.authService.currentUserValue.token
  }

  formatData(data: Farmer[]) {
    const options = Highcharts.getOptions(); 
    const chart = Highcharts.chart(this.chartOptions);
// chart.update()

  }



  loadData() {
    this.farmerService.find()
    .subscribe(this.formatData,
    err => {
      console.log(err)
    })
  }

  ngOnInit() {
    this.loadData()
  }
}
