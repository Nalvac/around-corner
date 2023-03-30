import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router, UrlSegment} from "@angular/router";
import {Observable} from "rxjs";
import { map } from 'rxjs/operators'
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit{
  title = 'around-corner';
  token: string = '';
  constructor(private router: Router, private route: ActivatedRoute) {

  }

  ngOnInit() {
    this.getCurrentRoute().subscribe(value => console.log(value));
    this.token = sessionStorage.getItem('token');
  }

  getCurrentRoute(): Observable<string> {
    return this.route.url.pipe(
      map((segments: UrlSegment[]) => '/' + segments.join('/'))
    );
  }
}
