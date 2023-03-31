import { NgModule } from '@angular/core';
import { FlexLayoutModule } from '@angular/flex-layout';
import { BrowserModule } from '@angular/platform-browser';
// import {MatToolbarModule} from '@angular/material/toolbar';

import { AppComponent } from './app.component';
import { MapComponent } from './map/map.component';
import { RoomCardComponent } from './room-card/room-card.component';
import { NavbarComponent } from './navbar/navbar.component';
import {MatDatepickerModule} from "@angular/material/datepicker";
import {MatInputModule} from "@angular/material/input";
import {MatNativeDateModule, MatOptionModule} from "@angular/material/core";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {NgbInputDatepicker} from "@ng-bootstrap/ng-bootstrap";
import {MatIconModule} from "@angular/material/icon";
import {BrowserAnimationsModule} from "@angular/platform-browser/animations";
import { BannerComponent } from './banner/banner.component';
import { HowItWorksComponent } from './how-it-works/how-it-works.component';
import { LoginComponent } from './login/login.component';
import {CarouselModule} from "ngx-bootstrap/carousel";
import {MatCardModule} from "@angular/material/card";
import {AppRoutingModule} from "./app.component.routing";
import { HomeComponent } from './home/home.component';
import { RegisterComponent } from './register/register.component';
import {HttpClientModule} from "@angular/common/http";
import {MatSelectModule} from "@angular/material/select";
import { FooterComponent } from './footer/footer.component';
import { RoomDetailComponent } from './room-detail/room-detail.component';
import { AdminReservationComponent } from './admin-reservation/admin-reservation.component';
import { AdminGlobalComponent } from './admin-global/admin-global.component';
import {TabsModule} from "ngx-bootstrap/tabs";
import { FormulaireAdminComponent } from './formulaire-admin/formulaire-admin.component';

@NgModule({
  declarations: [
    AppComponent,
    MapComponent,
    RoomCardComponent,
    NavbarComponent,
    BannerComponent,
    HowItWorksComponent,
    LoginComponent,
    HomeComponent,
    RegisterComponent,
    FooterComponent,
    RoomDetailComponent,
    AdminReservationComponent,
    AdminGlobalComponent,
    FormulaireAdminComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    FlexLayoutModule,
    MatDatepickerModule,
    MatInputModule,
    MatIconModule,
    MatNativeDateModule,
    FormsModule,
    NgbInputDatepicker,
    MatIconModule,
    CarouselModule.forRoot(),
    MatCardModule,
    ReactiveFormsModule,
    HttpClientModule,
    MatOptionModule,
    MatSelectModule,
    TabsModule.forRoot()
  ],
  providers: [
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
