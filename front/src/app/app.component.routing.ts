import {RouterModule, Routes} from "@angular/router";
import {NgModule} from "@angular/core";
import {LoginComponent} from "./login/login.component";
import {HomeComponent} from "./home/home.component";
import {RegisterComponent} from "./register/register.component";
import {RentDetailComponent} from "./rent-detail/rent-detail.component";
import {AddDeskComponent} from "./add-desk/add-desk.component";
import {ListBookComponent} from "./list-book/list-book.component";
import {MapComponent} from "./map/map.component";
import {ProfilUserComponent} from "./profil-user/profil-user.component";

import { LogoutComponent } from "./logout/logout.component";

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
  },
  {
    path: 'nouveau-bureau',
    component: AddDeskComponent,
  },
  {
    path: 'list-book',
    component: ListBookComponent
  },
  {
    path: 'map',
    component: MapComponent,
  },
  {
    path: 'profil',
    component: ProfilUserComponent
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
