import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ProfilNavbarComponent } from './profil-navbar.component';

describe('ProfilNavbarComponent', () => {
  let component: ProfilNavbarComponent;
  let fixture: ComponentFixture<ProfilNavbarComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ProfilNavbarComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ProfilNavbarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
