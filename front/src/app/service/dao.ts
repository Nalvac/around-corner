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
      return this.httpService.post('auth/register', data);
    }

    getDate() {}

}
