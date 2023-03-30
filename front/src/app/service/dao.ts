import { HttpService } from "./http.service";
import { Injectable } from "@angular/core";
import {UserModel} from "../model/user.model";
import {Observable} from "rxjs";
import {UserRegisterModel} from "../model/userRegister.model";

@Injectable({
  providedIn: 'root'
})
export class Dao {
    constructor(private httpService: HttpService ) {
    }
    connexion(data: UserModel): Observable<any> {
      return this.httpService.post('api/login', data);
    }
    signup(data: UserRegisterModel): Observable<any> {
      return this.httpService.post('api/register', data);
    }

    getCoordinates(address: string): void {
      this.httpService.getCoordinatesFromAddress(address).subscribe(
      (response) => {
        if (response && response.length > 0) {
          const latitude = parseFloat(response[0].lat);
          const longitude = parseFloat(response[0].lon);
          console.log(`Latitude: ${latitude}, Longitude: ${longitude}`);
        } else {
          console.log('No coordinates found for the given address.');
        }
      },
      (error) => {
        console.log('Error:', error);
      }
    );
  }

  getAllDesk(): Observable<any> {
      return this.httpService.get('api/desk-all')
  }

  getBooking(userId: string): Observable<any> {
    return this.httpService.get('api/booking/user/${userId}')
  }

  getDate() {}



}
