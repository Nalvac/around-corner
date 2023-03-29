import { Component } from '@angular/core';
import {FormControl} from "@angular/forms";

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent {
  model: any;

  selectedTypes = new FormControl();
  types = ['Type 1', 'Type 2', 'Type 3', 'Type 4'];
}
