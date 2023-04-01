import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ProfilPicturesComponent } from './profil-pictures.component';

describe('ProfilPicturesComponent', () => {
  let component: ProfilPicturesComponent;
  let fixture: ComponentFixture<ProfilPicturesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ProfilPicturesComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ProfilPicturesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
