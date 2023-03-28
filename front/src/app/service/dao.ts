import { HttpService } from "./http.service";
import { Injectable } from "@angular/core";

@Injectable()
export class Dao {
    constructor(private httpService: HttpService) {
    }

    getDate() {}

}