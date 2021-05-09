import { Component } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { NewFarmer } from 'src/app/api/models';
import { FarmerControllerService } from 'src/app/api/services/farmer-controller.service';
import provinces from 'src/app/services/provinces';

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
    education : [null, Validators.required]
    
  });

  hasUnitNumber = false;

  provinces = provinces;
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

    this.farmerService.create({ body }).subscribe(
      result => { 
        alert('Saved');

        },
      err => { console.log(err)});
  }
}
