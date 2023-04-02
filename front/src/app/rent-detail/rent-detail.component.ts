import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {Dao} from "../service/dao";
import {firstValueFrom} from "rxjs";
import {DeskModel} from "../model/desk.model";
import {LenderModel} from "../model/lender.model";
import {BookingRequestModel} from "../model/booking.request.model";
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {MatSnackBar} from "@angular/material/snack-bar";
import {UserConnectedInfoModel} from "../model/UserConnectedInfo.model";

@Component({
  selector: 'app-rent-detail',
  templateUrl: './rent-detail.component.html',
  styleUrls: ['./rent-detail.component.scss']
})
export class RentDetailComponent implements OnInit{

  desk: DeskModel = null;

  lender: LenderModel;

  user: UserConnectedInfoModel =  null;
  public dateForm: FormGroup;
  constructor(
    public param: ActivatedRoute,
    private fb: FormBuilder,
    public route: Router,
    private dao: Dao,
    private _snackBar: MatSnackBar
  ) {
    this.dateForm = this.fb.group({
      start : new FormControl('', Validators.compose([
        Validators.required,
        Validators.pattern('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$')
      ])),
      end: new FormControl('', Validators.compose([
        Validators.required
      ]))
    });
  }

  ngOnInit() {
    if (JSON.parse(localStorage.getItem('userConnected'))) {
      this.user = JSON.parse(localStorage.getItem('userConnected'))[0] ;
    }
    const id = this.param.snapshot.params['id'];
    firstValueFrom(this.dao.getDeskById(id)).then(
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
  booking() {
    if(sessionStorage.getItem('token') === null) {
      window.alert('Connecter afin de pourvoir réserver !');
      this.route.navigate(['connexion'])
    } else {

      const startDate = new Date(this.dateForm.get('start').value);
      const endDate = new Date(this.dateForm.get('end').value);

      const bookingRequest: BookingRequestModel = {
        deskId: this.desk.id.toString(),
        endDate: endDate.toLocaleDateString('fr-FR').replaceAll('/', '-'),
        price: this.desk.price.toString(),
        startDate: startDate.toLocaleDateString('fr-FR').replaceAll('/', '-'),
        userId: this.user.id,
      }
      firstValueFrom(this.dao.booking(bookingRequest)).then(
        (book) => {
          this._snackBar.open('Réservation réussie')
          setTimeout(() => {
            window.location.href = '';
          },2000)
        }
      )

    }
  }
}
