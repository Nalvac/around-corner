import {Component, Input, OnChanges, SimpleChange, SimpleChanges} from '@angular/core';
import {BookModel} from "../../model/book.model";
import {UserConnectedInfoModel} from "../../model/UserConnectedInfo.model";
import {DeskModel} from "../../model/desk.model";
import {firstValueFrom} from "rxjs";
import {Dao} from "../../service/dao";
import {LenderModel} from "../../model/lender.model";

@Component({
  selector: 'app-announcement-item',
  templateUrl: './announcement-item.component.html',
  styleUrls: ['./announcement-item.component.scss']
})
export class AnnouncementItemComponent implements OnChanges{
  @Input() book: BookModel = null;

  desk: DeskModel = null;

  lender: LenderModel = null;
  user: UserConnectedInfoModel = JSON.parse(localStorage.getItem('userConnected'))[0] as UserConnectedInfoModel;

  constructor(private dao: Dao) {
  }
  ngOnChanges(changes: {[propName: string]: SimpleChange}) {

    for (let i in changes) {
      switch (i) {
        case 'book':
            if(this.book) {
              this.getDesk(this.book.desk)
            }
          break;
      }
    }
  }
  getDesk(id: number) {
    firstValueFrom(this.dao.getDeskById(id.toString())).then(
      (desk) => {
        this.desk = desk[0];
        firstValueFrom(this.dao.getUserById(this.desk.user_id)).then(
          (user) => {
            this.lender = user[0];
          }
        )
      }
    )
  }
}
