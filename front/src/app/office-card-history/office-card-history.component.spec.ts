import { ComponentFixture, TestBed } from '@angular/core/testing';

import { OfficeCardHistoryComponent } from './office-card-history.component';

describe('OfficeCardHistoryComponent', () => {
  let component: OfficeCardHistoryComponent;
  let fixture: ComponentFixture<OfficeCardHistoryComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ OfficeCardHistoryComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(OfficeCardHistoryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
