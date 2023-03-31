import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {Dao} from "../service/dao";
import {DeskModel} from "../model/desk.model";
import {firstValueFrom} from "rxjs";
import {UserConnectedInfoModel} from "../model/UserConnectedInfo.model";

@Component({
  selector: 'app-add-desk',
  templateUrl: './add-desk.component.html',
  styleUrls: ['./add-desk.component.scss']
})
export class AddDeskComponent implements OnInit{

  options: Array<any> = [];

  types: Array<any>;
  selectedOption: number | null = null;
  userConnected: UserConnectedInfoModel = null;
  addDeskForm = new FormGroup({
    numberPlaces: new FormControl('', [Validators.required]),
    address: new FormControl('', [Validators.required]),
    price:  new FormControl('', [Validators.required]),
    city:  new FormControl('', [Validators.required]),
    zipCode:  new FormControl('', [Validators.required]),
    description:  new FormControl('', [Validators.required]),
    uid:  new FormControl(''),
    sdid:  new FormControl('', [Validators.required]),
    options: this.formBuilder.group(
      this.options.reduce((acc, option) => {
        acc[option.id] = new FormControl(false);
        return acc;
      }, {})
    ),
  });

  images: Array<string> = [];

  constructor(private dao: Dao, private formBuilder: FormBuilder) {}

  ngOnInit() {
    this.getOption();
    this.getTypes();
    this.userConnected = JSON.parse(localStorage.getItem('userConnected'))[0];
    console.log(this.userConnected);
  }

  onSubmit() {
      const deskData: DeskModel = {
        numberPlaces: parseInt(this.addDeskForm.get('numberPlaces').value),
        address: this.addDeskForm.get('address').value,
        price: parseInt(this.addDeskForm.get('price').value),
        city:  this.addDeskForm.get('city').value,
        zipCode: parseInt(this.addDeskForm.get('zipCode').value),
        description:  this.addDeskForm.get('description').value,
        uid:  this.userConnected.id,
        sdid:  parseInt(this.addDeskForm.get('sdid').value),
        tax: 0,
        images: this.images,
        options: [1,2]
      };
      firstValueFrom(this.dao.addDesk(deskData)).then(
        (addDesk) => {
          console.log(addDesk);
          this.images = [];
          window.location.href=''
        }
      )

  }
  imageSrc1: string | ArrayBuffer | null = null;
  imageSrc2: string | ArrayBuffer | null = null;
  imageSrc3: string | ArrayBuffer | null = null;


  onFileSelected1(event: Event) {
    const file = (event.target as HTMLInputElement).files![0];

    if (file) {
      this.images.push(file.name)
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
      this.images.push(file.name)
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
      this.images.push(file.name)
      const reader = new FileReader();
      reader.onload = (e) => {
        this.imageSrc3 = e.target?.result;
      };
      reader.readAsDataURL(file);
    }
  }

  getOption() {
    firstValueFrom(this.dao.getOption()).then(
      (option) =>{
        this.options = option;
      }
    )
  }
  getTypes() {
    firstValueFrom(this.dao.getTypes()).then(
      (types) =>{
        this.types = types;
      }
    )
  }

  setCheckBoxValues(checkboxValues: any) {
    const checkboxes = this.addDeskForm.get('options') as FormGroup;
    checkboxes.patchValue(checkboxValues);
  }
}
