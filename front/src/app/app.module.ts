import { NgModule } from '@angular/core';
import { FlexLayoutModule } from '@angular/flex-layout';
import { BrowserModule } from '@angular/platform-browser';

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
import { ProfilUserComponent } from './profil-user/profil-user.component';
import { ProfilBannerComponent } from './profil-banner/profil-banner.component';
import { ProfilPasswordUpdateComponent } from './profil-password-update/profil-password-update.component';
import { ProfilCertifComponent } from './profil-certif/profil-certif.component';
import { ProfilNavbarComponent } from './profil-navbar/profil-navbar.component';
import { ProfilInfoComponent } from './profil-info/profil-info.component';
import { ProfilPicturesComponent } from './profil-pictures/profil-pictures.component';
import { OfficeComponent } from './office/office.component';
import { OfficeAddComponent } from './office-add/office-add.component';
import { OfficeCardComponent } from './office-card/office-card.component';
import { OfficeCardHistoryComponent } from './office-card-history/office-card-history.component';
import { BookingComponent } from './booking/booking.component';
import { BookingComingComponent } from './booking-coming/booking-coming.component';
import { BookingComingCardComponent } from './booking-coming-card/booking-coming-card.component';
import { BookingHistoryComponent } from './booking-history/booking-history.component';
import { BookingHistoryCardComponent } from './booking-history-card/booking-history-card.component';

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
    ProfilUserComponent,
    ProfilBannerComponent,
    ProfilPasswordUpdateComponent,
    ProfilCertifComponent,
    ProfilNavbarComponent,
    ProfilInfoComponent,
    ProfilPicturesComponent,
    OfficeComponent,
    OfficeAddComponent,
    OfficeCardComponent,
    OfficeCardHistoryComponent,
    BookingComponent,
    BookingComingComponent,
    BookingComingCardComponent,
    BookingHistoryComponent,
    BookingHistoryCardComponent
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
  ],
  providers: [
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
