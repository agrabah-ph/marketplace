import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { FarmerControllerService } from 'src/app/api/services/farmer-controller.service';
import provinces from 'src/app/services/provinces';

@Component({
  selector: 'app-farm',
  templateUrl: './farm.component.html',
  styleUrls: ['./farm.component.scss']
})
export class FarmComponent implements OnInit {
  addressForm = this.fb.group({
    address: [null, Validators.required],
    address2: null,
    barangay: [null, Validators.required],
    province: [null, Validators.required],
    city: [null, Validators.required],
    postalCode: [null, Validators.compose([
      Validators.required, Validators.minLength(5), Validators.maxLength(5)])
    ],
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

  farmTypes = [{value:'individual', text: 'Individual'},
  {value:'cooperative', text: 'Cooperative'},
  {value:'association', text: 'Association'}];

  provinces = provinces;

  constructor(private fb: FormBuilder,
    private farmerService: FarmerControllerService) {}

  ngOnInit(): void {
  }
  onSubmit() {
    let body: any = this.addressForm.value;
    console.log(body)

  }
}
