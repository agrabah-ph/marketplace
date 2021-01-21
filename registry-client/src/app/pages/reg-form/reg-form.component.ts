import { Component } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { NewFarmer } from 'src/app/api/models';
import { FarmerControllerService } from 'src/app/api/services/farmer-controller.service';

@Component({
  selector: 'app-reg-form',
  templateUrl: './reg-form.component.html',
  styleUrls: ['./reg-form.component.scss']
})
export class RegFormComponent {
  addressForm = this.fb.group({

    prefix: null,
    firstName: [null, Validators.required],
    middleName: [null, Validators.required],
    lastName: [null, Validators.required],
    suffix: null,
    
    mobile: [null, Validators.required],
    gender: [null, Validators.required],
    civil: [null, Validators.required],
    birthdate: [null, Validators.required],
    religion: [null, Validators.required],

    mother: [null, Validators.required],
    isHousehold: null,
    isPwd: null,
    isBen: null,
    isInd: null,

    address: [null, Validators.required],
    address2: null,
    barangay: [null, Validators.required],
    province: [null, Validators.required],
    city: [null, Validators.required],
    postalCode: [null, Validators.compose([
      Validators.required, Validators.minLength(5), Validators.maxLength(5)])
    ],
    education : [null, Validators.required],

    livelihood: null,
    isAqua: null, isCrop: null, isDairy: null, isFruit: null, isMeat: null, isPoultry: null,
    
    farmType: null,
    farmName: [null, Validators.required],
    farmLot: [null, Validators.required],
    farmSince: [null, Validators.required],
    farmArea: [null, Validators.required],
    isIrrigated: null,
    isOrgMember: null,
    orgName: null,
    isConventional: null,
    isSustainable: null,
    isNatural: null,
    isIntegrated: null,
    isMonoculture: null,
    isOrganic: null
  });

  hasUnitNumber = false;

  provinces = ['Abra',	'Agusan del Norte',	'Agusan del Sur',	'Aklan',	'Albay',	'Antique',	'Apayao',	'Aurora',	'Basilan',	'Bataan',	'Batanes',	'Batangas',	'Benguet',	'Biliran',	'Bohol',	'Bukidnon',	'Bulacan',	'Cagayan',	'Camarines Norte',	'Camarines Sur',	'Camiguin',	'Capiz',	'Catanduanes',	'Cavite',	'Cebu',	'Compostela Valley',	'Cotabato',	'Davao del Norte',	'Davao del Sur',	'Davao Oriental',	'Eastern Samar',	'Guimaras',	'Ifugao',	'Ilocos Norte',	'Ilocos Sur',	'Iloilo',	'Isabela',	'Kalinga',	'La Union',	'Laguna',	'Lanao del Norte',	'Lanao del Sur',	'Leyte',	'Maguindanao',	'Marinduque',	'Masbate',	'Metro Manila',	'Misamis Occidental',	'Misamis Oriental',	'Mountain Province',	'Negros Occidental',	'Negros Oriental',	'Northern Samar',	'Nueva Ecija',	'Nueva Vizcaya',	'Occidental Mindoro',	'Oriental Mindoro',	'Palawan',	'Pampanga',	'Pangasinan',	'Quezon',	'Quirino',	'Rizal',	'Romblon',	'Samar',	'Sarangani',	'Siquijor',	'Sorsogon',	'South Cotabato',	'Southern Leyte',	'Sultan Kudarat',	'Sulu',	'Surigao del Norte',	'Surigao del Sur',	'Tarlac',	'Tawi-Tawi',	'Zambales',	'Zamboanga del Norte',	'Zamboanga del Sur',	'Zamboanga Sibugay'];
  statuses = [ 
    {value:'single', text: 'Single'},
    {value:'separated', text: 'Separated'},
    {value:'married', text: 'Married'},
    {value:'widowed', text: 'Widowed'}];
  religions = [
    {value:'roman-catholic', text: 'Roman Catholic'},
    {value:'islam', text: 'Islam'},
    {value:'iglesia-ni-cristo', text: 'Iglesia ni Cristo'},
    {value:'christian', text: 'Christian'},
    {value:'protestant', text: 'Protestant'},
    {value:'others', text: 'Others'}];
  eds = [
    {value:'none', text: 'None'},
    {value:'elem_grad', text: 'Elementary Graduate'},
    {value:'highschool_grad', text: 'High School Graduate'},
    {value:'college_grad', text: 'College Graduate'},
    {value:'vocational', text: 'Vocational'},
    {value:'elem_level_1-5', text: 'Elementary Level (1-5)'},
    {value:'highschool_level', text: 'High School Level'},
    {value:'college_level_1-3', text: 'College Level (1-3yrs)'},
    {value:'postgrad', text: 'Post-Graduate'}];
  farmTypes = [{value:'individual', text: 'Individual'},
  {value:'cooperative', text: 'Cooperative'},
  {value:'association', text: 'Association'}];

  constructor(
    private fb: FormBuilder,
    private farmerService: FarmerControllerService) {}

  onSubmit() {
    let body: NewFarmer = this.addressForm.value;
        
    Object.keys(body).map(key => {
      if (body[key] === null) {
        delete body[key];
      }
    })
    console.log(body);

    this.farmerService.create({ body }).subscribe(
      result => { 
        console.log(result);
        alert('Saved');

        },
      err => { console.log(err)});
  }
}
