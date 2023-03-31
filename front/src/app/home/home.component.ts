import {Component, OnInit} from '@angular/core';
import {Dao} from "../service/dao";
import {firstValueFrom} from "rxjs";
import {DeskModel} from "../model/desk.model";
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit{
  name = 'Angular';
  public lat;
  public lng;

  allDesk: Array<DeskModel> = [];

  constructor(private dao: Dao) {
  }
  public ngOnInit(): void {
    this.getAllDesk();
    this.getConnectedUser();
  }

   deg2rad(deg: number) {
    return deg * (Math.PI / 180);
  }
  getAllDesk() {
    firstValueFrom(this.dao.getAllDesk()).then(
      (desks) => {
        this.allDesk = desks;
      }
    )
  }

  getConnectedUser() {
    firstValueFrom(this.dao.getUserConnected()).then(
      (user) => {
        localStorage.setItem('userConnected', JSON.stringify(user))
      }
    )
  }

}
