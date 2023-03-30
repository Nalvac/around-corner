import { Component } from '@angular/core';
import {Dao} from "../service/dao";

@Component({
  selector: 'app-myrent',
  templateUrl: './myrent.component.html',
  styleUrls: ['./myrent.component.scss']
})
export class MyRentComponent {
    constructor(private dao: Dao) {
    }

    getBookings () {
        console.log(this.dao.getBooking('1'));
    }

}
