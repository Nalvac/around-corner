import { ComponentFixture, TestBed } from '@angular/core/testing';

import { OfficeAddComponent } from './office-add.component';

describe('OfficeAddComponent', () => {
  let component: OfficeAddComponent;
  let fixture: ComponentFixture<OfficeAddComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ OfficeAddComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(OfficeAddComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
