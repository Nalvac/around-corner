import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BookingComingCardComponent } from './booking-coming-card.component';

describe('BookingComingCardComponent', () => {
  let component: BookingComingCardComponent;
  let fixture: ComponentFixture<BookingComingCardComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ BookingComingCardComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BookingComingCardComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
