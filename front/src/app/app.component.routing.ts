import { FormulaireAdminComponent } from './formulaire-admin/formulaire-admin.component';
import { AdminGlobalComponent } from './admin-global/admin-global.component';
import { AdminReservationComponent } from './admin-reservation/admin-reservation.component';
import {RouterModule, Routes} from "@angular/router";
import {NgModule} from "@angular/core";
import {LoginComponent} from "./login/login.component";
import {HomeComponent} from "./home/home.component";
import {RegisterComponent} from "./register/register.component";

const routes: Routes = [
  {
    path: 'connexion',
    component: LoginComponent
  },
  {
    path: 'inscription',
    component: RegisterComponent
  },
  {
    path: '',
    component: HomeComponent
  },
  {
    path: 'admin-reservation',
    component: AdminReservationComponent
  },
    {
    path: 'admin-global',
    component: AdminGlobalComponent 
  },
  {
    path: 'formulaire-admin',
    component: FormulaireAdminComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
