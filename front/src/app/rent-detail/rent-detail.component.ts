import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {Dao} from "../service/dao";
import {firstValueFrom} from "rxjs";
import {DeskModel} from "../model/desk.model";
import {LenderModel} from "../model/lender.model";

@Component({
  selector: 'app-rent-detail',
  templateUrl: './rent-detail.component.html',
  styleUrls: ['./rent-detail.component.scss']
})
export class RentDetailComponent implements OnInit{
  displayedColumns: string[] = ['column1', 'column2'];
  dataSource = [
    { column1: 'Ligne 1, Colonne 1', column2: 'Ligne 1, Colonne 2' },
    { column1: 'Ligne 2, Colonne 1', column2: 'Ligne 2, Colonne 2' }
  ];

  desk: DeskModel = null;

  lender: LenderModel;

  constructor(public param: ActivatedRoute, public dao: Dao, public route: Router) {
  }

  ngOnInit() {
    const id = this.param.snapshot.params['id'];
    firstValueFrom(this.dao.getDeskById(id)).then(
      (desk) => {
        console.log(desk);
        this.desk = desk[0];
        firstValueFrom(this.dao.getUserById(this.desk.user_id)).then(
          (user) => {
            console.log(user);
            this.lender = user[0];
          }
        )
      }
    )

  }
}
