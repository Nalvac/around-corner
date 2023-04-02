import { Component } from '@angular/core';
import {UserConnectedInfoModel} from "../../model/UserConnectedInfo.model";

@Component({
  selector: 'app-profil-banner',
  templateUrl: './profil-banner.component.html',
  styleUrls: ['./profil-banner.component.scss']
})
export class ProfilBannerComponent {
  user: UserConnectedInfoModel = null;
  constructor() {
  }

  ngOnInit() {
    this.user = JSON.parse( localStorage.getItem('userConnected'))[0] as UserConnectedInfoModel;
  }
}
