import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { HomeComponent } from './pages/home/home.component';
import { FarmersComponent } from './pages/farmers/farmers.component';
import { RegFormComponent } from './pages/reg-form/reg-form.component';

const routes: Routes = [
  { path: '', component: HomeComponent},
  { path: 'farmers', component: FarmersComponent},
  { path: 'reg-form', component: RegFormComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
