import {Component, OnInit} from '@angular/core';
import {firstValueFrom} from "rxjs";
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {UserModel} from "../model/user.model";
import {Dao} from "../service/dao";
import {MatSnackBar} from '@angular/material/snack-bar';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit{

  private user: UserModel = null;
  public userForm:FormGroup; // variable is created of type FormGroup is created

  updateMenuLinkViaParent: Function | undefined;

  constructor(
    private fb: FormBuilder,
    private dao: Dao,
    private _snackBar: MatSnackBar
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

  ngOnInit() {
    sessionStorage.removeItem('token');
  }

  submit() {
      console.log(this.userForm.value)

    this.user = this.userForm.value as UserModel;

    firstValueFrom(this.dao.connexion(this.user))
      .then((data) => {
        sessionStorage.setItem('token', data.token);
        setTimeout(() => {
          this._snackBar.open('Connexion réussie')
        },2000)
        window.location.href = '';

        if (this.updateMenuLinkViaParent) {
          this.updateMenuLinkViaParent();
        }
      }, (error) => {
        setTimeout(() => {
          this._snackBar.open('Mot de passe ou email érronné')
        },2000)
      })
  }


}
