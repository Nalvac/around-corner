import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ProfilBannerComponent } from './profil-banner.component';

describe('ProfilBannerComponent', () => {
  let component: ProfilBannerComponent;
  let fixture: ComponentFixture<ProfilBannerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ProfilBannerComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ProfilBannerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
