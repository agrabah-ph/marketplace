import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { HomeComponent } from './pages/home/home.component';
import { LoginComponent } from './pages/login/login.component';
import { FarmersComponent } from './pages/farmers/farmers.component';
import { FarmerComponent } from './pages/farmer/farmer.component';
import { RegFormComponent } from './pages/reg-form/reg-form.component';
import { AuthenticationService } from 'src/app/services/authentication.service';

const routes: Routes = [
  { path: '', component: HomeComponent, canActivate: [AuthenticationService]},
  { path: 'login',  component: LoginComponent},
  { path: 'farmers', component: FarmersComponent},
  { path: 'farmer/:id', component: FarmerComponent},
  { path: 'reg-form', component: RegFormComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
