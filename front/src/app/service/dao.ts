import { HttpService } from "./http.service";
import { Injectable } from "@angular/core";
import {UserModel} from "../model/user.model";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class Dao {
    constructor(private httpService: HttpService ) {
    }
    connexion(data: UserModel): Observable<any> {
      return this.httpService.post('auth/login', data);
    }

    getDate() {}

}
