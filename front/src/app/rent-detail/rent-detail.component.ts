import { Component } from '@angular/core';

@Component({
  selector: 'app-rent-detail',
  templateUrl: './rent-detail.component.html',
  styleUrls: ['./rent-detail.component.scss']
})
export class RentDetailComponent {
  displayedColumns: string[] = ['column1', 'column2'];
  dataSource = [
    { column1: 'Ligne 1, Colonne 1', column2: 'Ligne 1, Colonne 2' },
    { column1: 'Ligne 2, Colonne 1', column2: 'Ligne 2, Colonne 2' }
  ];
}
