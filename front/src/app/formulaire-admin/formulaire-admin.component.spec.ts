import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulaireAdminComponent } from './formulaire-admin.component';

describe('FormulaireAdminComponent', () => {
  let component: FormulaireAdminComponent;
  let fixture: ComponentFixture<FormulaireAdminComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulaireAdminComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(FormulaireAdminComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
