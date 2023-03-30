import { HttpErrorResponse } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { firstValueFrom } from 'rxjs';
import {Dao} from "../service/dao";

@Component({
  selector: 'app-myrent',
  templateUrl: './myrent.component.html',
  styleUrls: ['./myrent.component.scss']
})
export class MyRentComponent  implements OnInit{
    constructor(private dao: Dao) {
        
    }

    ngOnInit() {
        this.getBookings();
    }

    getBookings () {
        firstValueFrom(this.dao.getBooking('1')).then((data) => {
            console.log(data);

        }).catch((e: HttpErrorResponse) => {
            console.log(e);
        });
    }

}
