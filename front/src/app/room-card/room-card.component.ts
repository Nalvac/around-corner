import {Component, Input, OnInit} from '@angular/core';
import {DeskModel} from "../model/desk.model";
import {Dao} from "../service/dao";
import {firstValueFrom} from "rxjs";
import {Router} from "@angular/router";

@Component({
  selector: 'app-room-card',
  templateUrl: './room-card.component.html',
  styleUrls: ['./room-card.component.scss']
})
export class RoomCardComponent implements OnInit{

  @Input() desk: DeskModel = null;

  options: Array<any>;

  distance: string = '';

  constructor(private dao: Dao, public route: Router) {
  }

  ngOnInit() {
    this.getLocation();
    this.getDist(this.desk.adress +' '+this.desk.city+' '+this.desk.zipCode)
  }

  public lat;
  public lng;
  getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          this.lat = position.coords.latitude;
          this.lng = position.coords.longitude;
          console.log(this.lat, this.lng);
        },
        (error) => {
          console.error('Error getting location:', error);
        }
      );
    } else {
      console.error('Geolocation is not supported by this browser.');
    }
  }

  getDistanceFromLatLonInKm(lat2: number, lon2: number) {
    const R = 6371; // Rayon de la Terre en km
    console.log(this.lat, this.lng)
    console.log(lat2, lon2)
    const dLat = this.deg2rad(lat2 - this.lat);
    const dLon = this.deg2rad(lon2 - this.lng);
    const a =
      Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(this.deg2rad(this.lat)) * Math.cos(this.deg2rad(lat2)) *
      Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = R * c; // Distance en km
    return distance.toFixed(2);
  }

  deg2rad(deg: number) {
    return deg * (Math.PI / 180);
  }

  getDist(adress: string) {
    firstValueFrom(this.dao.getCoordinates(adress)).then(
      (response) => {
        if (response && response.length > 0) {
          const latitude = parseFloat(response[0].lat);
          const longitude = parseFloat(response[0].lon);
          this.distance = this.getDistanceFromLatLonInKm(latitude, longitude);
          return {
            lat: parseFloat(response[0].lat),
            lng: parseFloat(response[0].lon),
          }
        } else {
          console.log('No coordinates found for the given address.');
          this.distance = '0';
          return {
            lat: 0,
            lng: 0,
          }
        }
      })
    }

  }
