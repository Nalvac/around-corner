import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BookingComingComponent } from './booking-coming.component';

describe('BookingComingComponent', () => {
  let component: BookingComingComponent;
  let fixture: ComponentFixture<BookingComingComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ BookingComingComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BookingComingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
