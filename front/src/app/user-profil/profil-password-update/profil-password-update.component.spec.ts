import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ProfilPasswordUpdateComponent } from './profil-password-update.component';

describe('ProfilPasswordUpdateComponent', () => {
  let component: ProfilPasswordUpdateComponent;
  let fixture: ComponentFixture<ProfilPasswordUpdateComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ProfilPasswordUpdateComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ProfilPasswordUpdateComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
