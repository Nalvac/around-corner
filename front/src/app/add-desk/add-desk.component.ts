import { Component } from '@angular/core';
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {Dao} from "../service/dao";
import {DeskModel} from "../model/desk.model";

@Component({
  selector: 'app-add-desk',
  templateUrl: './add-desk.component.html',
  styleUrls: ['./add-desk.component.scss']
})
export class AddDeskComponent {
  addDeskForm = new FormGroup({
    numberPlaces: new FormControl('', [Validators.required]),
    address: new FormControl('', [Validators.required]),
    price:  new FormControl('', [Validators.required]),
    city:  new FormControl('', [Validators.required]),
    zipCode:  new FormControl('', [Validators.required]),
    description:  new FormControl('', [Validators.required]),
    uid:  new FormControl('', [Validators.required]),
    sdid:  new FormControl('', [Validators.required]),
  });

  constructor(private signupService: Dao) {}

  onSubmit() {
    console.log(this.addDeskForm.value);
    if (this.addDeskForm.valid) {
      const deskData: DeskModel = {
        numberPlaces: parseInt(this.addDeskForm.get('numberPlaces').value),
        address: this.addDeskForm.get('address').value,
        price: parseInt(this.addDeskForm.get('price').value),
        city:  this.addDeskForm.get('city').value,
        zipCode: parseInt(this.addDeskForm.get('zipCode').value),
        description:  this.addDeskForm.get('description').value,
        uid:  parseInt(this.addDeskForm.get('uid').value),
        sdid:  parseInt(this.addDeskForm.get('sdid').value) ,
      };
    }
  }
  imageSrc1: string | ArrayBuffer | null = null;
  imageSrc2: string | ArrayBuffer | null = null;
  imageSrc3: string | ArrayBuffer | null = null;

  fileOver(event: any): void {
    console.log('File over');
  }

  fileLeave(event: any): void {
    console.log('File leave');
  }

  onFileSelected1(event: Event) {
    const file = (event.target as HTMLInputElement).files![0];

    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        this.imageSrc1 = e.target?.result;
      };
      reader.readAsDataURL(file);
    }
  }
  onFileSelected2(event: Event) {
    const file = (event.target as HTMLInputElement).files![0];

    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        this.imageSrc2 = e.target?.result;
      };
      reader.readAsDataURL(file);
    }
  }
  onFileSelected3(event: Event) {
    const file = (event.target as HTMLInputElement).files![0];

    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        this.imageSrc3 = e.target?.result;
      };
      reader.readAsDataURL(file);
    }
  }
}
