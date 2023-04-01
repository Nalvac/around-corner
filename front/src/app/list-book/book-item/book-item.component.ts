import {Component, Input} from '@angular/core';
import {DeskModel} from "../../model/desk.model";

@Component({
  selector: 'app-book-item',
  templateUrl: './book-item.component.html',
  styleUrls: ['./book-item.component.scss']
})
export class BookItemComponent {
  @Input() desk: DeskModel = null;
}
