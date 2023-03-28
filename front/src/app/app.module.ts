import { NgModule } from '@angular/core';
import { FlexLayoutModule } from '@angular/flex-layout';
import { BrowserModule } from '@angular/platform-browser';

import { AppComponent } from './app.component';
import { MapComponent } from './map/map.component';
import { RoomCardComponent } from './room-card/room-card.component';
import { NavbarComponent } from './navbar/navbar.component';

@NgModule({
  declarations: [
    AppComponent,
    MapComponent,
    RoomCardComponent,
    NavbarComponent
  ],
  imports: [
    BrowserModule,
    FlexLayoutModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
