import { Component } from '@angular/core';
import {firstValueFrom} from "rxjs";
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {UserModel} from "../model/user.model";
import {Dao} from "../service/dao";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent {

  private user: UserModel = null;
  public userForm:FormGroup; // variable is created of type FormGroup is created

  updateMenuLinkViaParent: Function | undefined;

  constructor(
    private fb: FormBuilder,
    private dao: Dao
  ) {
    this.userForm = this.fb.group({
      email : new FormControl('', Validators.compose([
        Validators.required,
        Validators.pattern('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$')
      ])),
      password: new FormControl('', Validators.compose([
        Validators.required
      ]))
    });
  }

  submit() {
      console.log(this.userForm.value)

    this.user = this.userForm.value as UserModel;

    firstValueFrom(this.dao.connexion(this.user))
      .then((data) => {
        sessionStorage.setItem('token', data.token);
        sessionStorage.setItem('refresh_token', data.refresh_token);
        window.location.href = '/compte';
        if (this.updateMenuLinkViaParent) {
          this.updateMenuLinkViaParent();
        }
      })
  }
}
