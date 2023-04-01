import {Component, OnInit} from '@angular/core';
import {Dao} from "../service/dao";
import {MatSnackBar} from "@angular/material/snack-bar";
import {firstValueFrom} from "rxjs";
import {UserConnectedInfoModel} from "../model/UserConnectedInfo.model";
import {DeskModel} from "../model/desk.model";

@Component({
  selector: 'app-list-book',
  templateUrl: './list-book.component.html',
  styleUrls: ['./list-book.component.scss']
})
export class ListBookComponent implements OnInit{

  user: UserConnectedInfoModel = JSON.parse(localStorage.getItem('userConnected'))[0];

  deskOwner: Array<DeskModel> = [];
  constructor(
    private dao: Dao,
    private _snackBar: MatSnackBar
  ) {

  }
  ngOnInit() {
    this.getListDeskOwner();
  }

  getListDeskOwner() {
    console.log(this.user);
    firstValueFrom(this.dao.getOwnerDesk(this.user.id)).then(
      (deskList) => {
        this.deskOwner = deskList;
      }
    )
  }
}
