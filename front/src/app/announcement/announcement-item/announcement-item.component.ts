import {Component, Input} from '@angular/core';
import {BookModel} from "../../model/book.model";

@Component({
  selector: 'app-announcement-item',
  templateUrl: './announcement-item.component.html',
  styleUrls: ['./announcement-item.component.scss']
})
export class AnnouncementItemComponent {
  @Input() book: BookModel = null;
}
