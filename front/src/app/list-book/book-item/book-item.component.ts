import {Component, Input, SimpleChange} from '@angular/core';
import {DeskModel} from "../../model/desk.model";
import {UserConnectedInfoModel} from "../../model/UserConnectedInfo.model";
import {firstValueFrom} from "rxjs";
import {Dao} from "../../service/dao";

@Component({
  selector: 'app-book-item',
  templateUrl: './book-item.component.html',
  styleUrls: ['./book-item.component.scss']
})
export class BookItemComponent {
  @Input() desk: DeskModel = null;
  user: UserConnectedInfoModel = JSON.parse(localStorage.getItem('userConnected'))[0] as UserConnectedInfoModel;

  constructor(private dao: Dao) {
  }
  ngOnChanges(changes: {[propName: string]: SimpleChange}) {

    for (let i in changes) {
      switch (i) {
        case 'desk':

      }
    }
  }
  getDesk(id: string) {
    firstValueFrom(this.dao.getDeskById(id)).then(
      (desk) => {
        this.desk = desk[0];
        firstValueFrom(this.dao.getUserById(this.desk.user_id)).then(
          (user) => {
          }
        )
      }
    )
  }
}
