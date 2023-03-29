import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FlexLayoutModule } from '@angular/flex-layout';


import { AppComponent } from './app.component';
import { NavbarComponent } from './navbar/navbar.component';
import { ProfilUserComponent } from './profil-user/profil-user.component';

@NgModule({
  declarations: [
    AppComponent,
    NavbarComponent,
    ProfilUserComponent
  ],
  imports: [
    BrowserModule,
    FlexLayoutModule 
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
