import { HttpService } from "./http.service";
import { Injectable } from "@angular/core";
import {UserModel} from "../model/user.model";
import {Observable} from "rxjs";
import {UserRegisterModel} from "../model/userRegister.model";
import {DeskModel} from "../model/desk.model";
import {UserConnectedInfoModel} from "../model/UserConnectedInfo.model";
import {LenderModel} from "../model/lender.model";
import {BookingRequestModel} from "../model/booking.request.model";
import {BookModel} from "../model/book.model";

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
      return this.httpService.post('api/register', data, false);
    }

    getCoordinates(address: string): Observable<any> {
      return this.httpService.getCoordinatesFromAddress(address)
    }
  getAllDesk(): Observable<Array<DeskModel>> {
      return this.httpService.get('api/desk-all', false)
  }

  getOption(): Observable<Array<any>> {
      return this.httpService.get('api/option', false)
  }

  getTypes(): Observable<Array<{id: string, name:string}>> {
    return this.httpService.get('api/status-desk', false)
  }
  getUserConnected(): Observable<UserConnectedInfoModel> {
      return this.httpService.get('api/user-connected')
  }

  addDesk(payload: DeskModel): Observable<any> {
      return this.httpService.post('api/desk-add', payload)
  }

  getUserById(id: string): Observable<Array<LenderModel>> {
      return this.httpService.get('api/user/'+ id, false)
  }

  getDeskById(deskId: string): Observable<Array<DeskModel>> {
      return this.httpService.get('api/desk/'+deskId, false);
  }

  booking(bookingData: BookingRequestModel): Observable<any> {
      return this.httpService.post('api/booking', bookingData)
  }
  getUserBook(userId: string): Observable<Array<BookModel>> {
      return this.httpService.get('api/booking/user/'+userId)
  }

}
