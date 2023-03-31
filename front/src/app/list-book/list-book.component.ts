import {Component, OnInit} from '@angular/core';
import {Dao} from "../service/dao";
import {MatSnackBar} from "@angular/material/snack-bar";
import {firstValueFrom} from "rxjs";
import {UserConnectedInfoModel} from "../model/UserConnectedInfo.model";
import {BookModel} from "../model/book.model";

@Component({
  selector: 'app-list-book',
  templateUrl: './list-book.component.html',
  styleUrls: ['./list-book.component.scss']
})
export class ListBookComponent implements OnInit{

  user: UserConnectedInfoModel = JSON.parse(localStorage.getItem('userConnected'))[0];

  bookList: Array<BookModel> = [];
  constructor(
    private dao: Dao,
    private _snackBar: MatSnackBar
  ) {

  }
  ngOnInit() {
    this.getListBook();
  }

  getListBook() {
    console.log(this.user);
    firstValueFrom(this.dao.getUserBook(this.user.id)).then(
      (bookList) => {
        console.log(bookList);
        this.bookList = bookList;
      }
    )
  }
}
