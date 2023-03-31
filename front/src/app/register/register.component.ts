import { Component } from '@angular/core';
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {Dao} from "../service/dao";
import {UserRegisterModel} from "../model/userRegister.model";
import {firstValueFrom} from "rxjs";

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent {

  hidePassword = true;
  signupForm = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', [Validators.required, Validators.minLength(3)]),
    firstName: new FormControl('', [Validators.required]),
    lastName: new FormControl('', [Validators.required]),
    gender: new FormControl('', [Validators.required]),
    nationality: new FormControl('', [Validators.required]),
    birthDate: new FormControl('', [Validators.required]),
    statusUsersId: new FormControl('', [Validators.required]),
    zipCode: new FormControl('', [Validators.required]),
    city: new FormControl('', [Validators.required]),
    adress: new FormControl('', [Validators.required]),
    roles: new FormControl('', [Validators.required])
  });

  constructor(private signupService: Dao) {}

  onSubmit() {
    console.log(this.signupForm.value);
    if (this.signupForm.valid) {
      const signupData: UserRegisterModel = {
        adress: this.signupForm.get('adress').value,
        email: this.signupForm.get('email').value,
        password: this.signupForm.get('password').value,
        firstName: this.signupForm.get('firstName').value,
        lastName: this.signupForm.get('lastName').value,
        gender: this.signupForm.get('gender').value,
        nationality: this.signupForm.get('nationality').value,
        birthDate: this.signupForm.get('birthDate').value,
        statusUsersId: this.signupForm.get('statusUsersId').value,
        roles: this.signupForm.get('roles').value
      };
      firstValueFrom(this.signupService.signup(signupData))
        .then((data) => {
          console.log(data);
        })
    }
  }
}
