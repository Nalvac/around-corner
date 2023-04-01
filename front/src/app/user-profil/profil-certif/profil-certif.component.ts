import { Component } from '@angular/core';
import {firstValueFrom} from "rxjs";
import {Dao} from "../../service/dao";
import {UserConnectedInfoModel} from "../../model/UserConnectedInfo.model";
import {MatSnackBar} from "@angular/material/snack-bar";

@Component({
  selector: 'app-profil-certif',
  templateUrl: './profil-certif.component.html',
  styleUrls: ['./profil-certif.component.scss']
})
export class ProfilCertifComponent {

  user: UserConnectedInfoModel = null;
  constructor(private dao: Dao, private _snackBar: MatSnackBar) {
  }


  ngOnInit() {
    this.user = JSON.parse( localStorage.getItem('userConnected'))[0] as UserConnectedInfoModel;
  }
  sendCertif(){
    firstValueFrom(this.dao.sendCertification(this.user.id)).then(
      (res) => {
        this._snackBar.open(res.message);
      }
    )
  }
}
