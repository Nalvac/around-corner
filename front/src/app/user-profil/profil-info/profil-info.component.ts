import {Component, OnInit} from '@angular/core';
import {UserConnectedInfoModel} from "../../model/UserConnectedInfo.model";

@Component({
  selector: 'app-profil-info',
  templateUrl: './profil-info.component.html',
  styleUrls: ['./profil-info.component.scss']
})
export class ProfilInfoComponent implements OnInit{

  user: UserConnectedInfoModel = null;
  constructor() {
  }

  ngOnInit() {
    this.user = JSON.parse( localStorage.getItem('userConnected'))[0] as UserConnectedInfoModel;
  }
}
