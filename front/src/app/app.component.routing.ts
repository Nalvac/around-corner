import {RouterModule, Routes} from "@angular/router";
import {NgModule} from "@angular/core";
import {LoginComponent} from "./login/login.component";
import {HomeComponent} from "./home/home.component";
import {RegisterComponent} from "./register/register.component";
import {RentDetailComponent} from "./rent-detail/rent-detail.component";

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
    path: ':id/detail',
    component: RentDetailComponent,
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
