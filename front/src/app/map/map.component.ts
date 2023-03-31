import {Component, AfterViewInit, OnInit} from '@angular/core';
import * as L from 'leaflet';
import {firstValueFrom} from "rxjs";
import {DeskModel} from "../model/desk.model";
import {Dao} from "../service/dao";

@Component({
  selector: 'app-map',
  templateUrl: './map.component.html',
  styleUrls: ['./map.component.scss']
})
export class MapComponent implements AfterViewInit, OnInit {
  map: any;
  public lat;
  public lng;

  allDesk: Array<DeskModel> = [];

  customIcon = L.icon({
    iconUrl: 'assets/marker-icon-2x.png',
    iconSize: [38, 55], // Taille de l'icône personnalisée
    iconAnchor: [22, 94], // Point d'ancrage de l'icône
    popupAnchor: [-3, -76] // Point d'ancrage du popup par rapport à l'icône
  });

  homeIcon = L.icon({
                    iconUrl: 'assets/hom-maker.png',
                    iconSize: [38, 55], // Taille de l'icône personnalisée
                    iconAnchor: [22, 94], // Point d'ancrage de l'icône
                    popupAnchor: [-3, -76] // Point d'ancrage du popup par rapport à l'icône
                  });

  private initMap(): void {
    this.getLocation();
    this.map = L.map('map', {
      center: [ 45.7712825, 4.8844634 ],
      zoom: 12
    });

    const tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
      minZoom: 3,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });

    tiles.addTo(this.map);
  }

  constructor(private dao: Dao) { }

  ngAfterViewInit(): void {
    this.initMap();
  }
  ngOnInit() {
    this.getLocation();

    this.getAllDesk();
  }

  getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          this.lat = position.coords.latitude;
          this.lng = position.coords.longitude;
          const marker = L.marker([this.lat, this.lng], {icon: this.customIcon})
            .addTo(this.map)
            .bindPopup('Vous êtes Ici.<br>');
          marker.openPopup()
        },
        (error) => {
          console.error('Error getting location:', error);
        }
      );
    } else {
      console.error('Geolocation is not supported by this browser.');
    }
  }

  addMarker() {
    for (let desk of this.allDesk) {
      firstValueFrom(this.dao.getCoordinates(desk.adress +' '+desk.city+' '+desk.zipCode)).then(
        (response) => {
          if (response && response.length > 0) {
            const latitude = parseFloat(response[0].lat);
            const longitude = parseFloat(response[0].lon);

            const marker = L.marker([latitude, longitude], {icon: this.homeIcon})
              .addTo(this.map)
              .bindPopup(desk.adress + ' '  +desk.city+ '<br> ' +desk.price + ' €/jour ' + '<a href=' +desk.id+'/detail>Ici</a>');
            marker.openPopup();
          } else {
            console.log('No coordinates found for the given address.');
          }
        })
    }

  }
  getAllDesk() {
    firstValueFrom(this.dao.getAllDesk()).then(
      (desks) => {
        this.allDesk = desks;
      }
    ).then(
      () => {
        this.addMarker();
      }
    )
  }

}
