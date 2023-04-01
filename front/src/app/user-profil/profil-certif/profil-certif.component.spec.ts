import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ProfilCertifComponent } from './profil-certif.component';

describe('ProfilCertifComponent', () => {
  let component: ProfilCertifComponent;
  let fixture: ComponentFixture<ProfilCertifComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ProfilCertifComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ProfilCertifComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
