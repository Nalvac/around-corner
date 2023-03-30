import {Component, OnInit} from '@angular/core';
import {Dao} from "../service/dao";
import {firstValueFrom, Observable} from "rxjs";
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit{
  name = 'Angular';
  public lat;
  public lng;

  constructor(private dao: Dao) {
  }
  public ngOnInit(): void {
    this.getLocation();
    const distance = this.getDistanceFromLatLonInKm(48.858093, 2.294694, 51.50722, -0.127758);
    console.log(`Distance entre Paris et Londres : ${distance} km`);
    this.dao.getCoordinates('150 rue du 4 août 1789 villeurbanne');
  }

  getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition((position: any) => {
          if (position) {
            console.log("Latitude: " + position.coords.latitude +
              "Longitude: " + position.coords.longitude);
            this.lat = position.coords.latitude;
            this.lng = position.coords.longitude;
            console.log(this.lat);
            console.log(this.lat);
          }
        },
        (error: GeolocationPositionError) => console.log(error));
    } else {
      alert("Geolocation is not supported by this browser.");
    }
  }

  getDistanceFromLatLonInKm(lat1: number, lon1: number, lat2: number, lon2: number) {
    const R = 6371; // Rayon de la Terre en km
    const dLat = this.deg2rad(lat2 - lat1);
    const dLon = this.deg2rad(lon2 - lon1);
    const a =
      Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(this.deg2rad(lat1)) * Math.cos(this.deg2rad(lat2)) *
      Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = R * c; // Distance en km
    return distance.toFixed(2);
  }

   deg2rad(deg: number) {
    return deg * (Math.PI / 180);
  }
  getAllDesk() {
    firstValueFrom(this.dao.getAllDesk()).then(

    )
  }

}
