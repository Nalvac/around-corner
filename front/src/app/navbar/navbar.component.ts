import {ChangeDetectorRef, Component, OnInit} from '@angular/core';
import {FormControl, FormGroup} from "@angular/forms";
import {Router} from "@angular/router";
import {Dao} from "../service/dao";
import {firstValueFrom} from "rxjs";

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit{
  model: any;
  token = sessionStorage.getItem('token');

  selectedTypes = new FormControl();
  range = new FormGroup({
    start: new FormControl<Date | null>(null),
    end: new FormControl<Date | null>(null),
  });

  options: Array<any> = [];

  types: Array<any> = [];


  constructor(public route: Router, private dao: Dao, private cdr: ChangeDetectorRef) {
  }

  ngOnInit() {
    this.getTypes();
    this.getOption();
  }

  getOption() {
    firstValueFrom(this.dao.getOption()).then(
      (option) =>{
        this.types = option;
        this.cdr.markForCheck();
      }
    )
  }
  getTypes() {
    firstValueFrom(this.dao.getTypes()).then(
      (types) =>{
        this.options = types;
        this.cdr.markForCheck();
      }
    )
  }
}
