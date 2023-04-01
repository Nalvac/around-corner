import { Component } from '@angular/core';
import {Dao} from "../service/dao";
import {MatSnackBar} from "@angular/material/snack-bar";
import {firstValueFrom} from "rxjs";
import {UserConnectedInfoModel} from "../model/UserConnectedInfo.model";
import {BookModel} from "../model/book.model";

@Component({
  selector: 'app-announcement',
  templateUrl: './announcement.component.html',
  styleUrls: ['./announcement.component.scss']
})
export class AnnouncementComponent {

  user: UserConnectedInfoModel = JSON.parse(localStorage.getItem('userConnected'))[0];
  bookList: Array<BookModel> = [];
  DeskList: Array<BookModel> = [];
  constructor(
    private dao: Dao,
    private _snackBar: MatSnackBar
  ) {

  }
  ngOnInit() {
    this.getListBooking();
  }

  getListBooking() {
    firstValueFrom(this.dao.getUserBook(this.user.id)).then(
      (bookList) => {
        this.bookList = bookList
      }
    )
  }

}
