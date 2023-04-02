import {AfterContentInit, ChangeDetectorRef, Component, OnInit} from '@angular/core';
import {FormArray, FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {Dao} from "../service/dao";
import {DeskModel} from "../model/desk.model";
import {firstValueFrom} from "rxjs";
import {UserConnectedInfoModel} from "../model/UserConnectedInfo.model";
import {MatSnackBar} from "@angular/material/snack-bar";
import {ActivatedRoute} from "@angular/router";

@Component({
  selector: 'app-add-desk',
  templateUrl: './add-desk.component.html',
  styleUrls: ['./add-desk.component.scss']
})
export class AddDeskComponent implements OnInit, AfterContentInit{

  options: Array<any> = [];

  isUpdate: boolean = false;
  types: Array<any> = [];
  optionLength: number | null = null;
  userConnected: UserConnectedInfoModel = null;
  addDeskForm: FormGroup;

  desk: DeskModel = null

  images: Array<string> = [];

  constructor(
    private dao: Dao,
    private formBuilder: FormBuilder,
    private cdr: ChangeDetectorRef,

    private param: ActivatedRoute,
    private _snackBar: MatSnackBar,) {
  }

  ngAfterContentInit() {
    this.getOption();
  }

  ngOnInit() {
    const id = this.param.snapshot.params['id'];
    if(id) {
      this.isUpdate = true;
      this.getDesk(id)
    }
    this.getOption();
    this.getTypes();
    this.userConnected = JSON.parse(localStorage.getItem('userConnected'))[0];
    this.initForm();
    this.addDeskForm.valueChanges.subscribe((change) => {

    })
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
        this.isUpdate = false;
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
        this.isUpdate = false;
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
        this.isUpdate = false;
        this.imageSrc3 = e.target?.result;
      };
      reader.readAsDataURL(file);
    }
  }

  getOption() {
    firstValueFrom(this.dao.getOption()).then(
      (option) =>{
        this.options = option;
        console.log(this.options);
        if(this.isUpdate){
          this.setAddFormValues(this.desk);
          const optionsArray = new FormArray(
            this.options.map(option => new FormControl(this.desk.options.hasOwnProperty(option.id)))
          );
          this.addDeskForm.setControl('options', optionsArray);
        } else {
          this.setAddFormValues(this.desk);
          const optionsArray = new FormArray(
            this.options.map(() => new FormControl(false))
          );
          this.addDeskForm.setControl('options', optionsArray);
        }
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

  onSubmit() {
    const optionsSelected = this.addDeskForm.get('options').value;
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
      options: optionsSelected.reduce((acc, value, index) => {
        if(value) {
          acc.push(index+1);
        }
        return acc;
      }, [])
    };
    if (this.isUpdate) {
      firstValueFrom(this.dao.updateDesk(this.desk.id.toString(), deskData)).then(
        (desUpdated) => {
          this.images = [];
          this._snackBar.open(desUpdated.message);
          setTimeout(() => {
            window.location.href = this.desk.id+'/edit';
          },2000)
        }
      )
    } else {
      firstValueFrom(this.dao.addDesk(deskData)).then(
        (addDesk) => {
          console.log(addDesk);
          this.images = [];
          this._snackBar.open('Bureau ajouter')
          setTimeout(() => {
            window.location.href = '';
          },2000)
        },
        (error) => {
          window.alert('Veuillez remplir tout les champs!')
        }
      )
    }

  }

  initForm() {
    this.addDeskForm = new FormGroup({
      numberPlaces: new FormControl('', [Validators.required]),
      address: new FormControl('', [Validators.required]),
      price:  new FormControl('', [Validators.required]),
      city:  new FormControl('', [Validators.required]),
      zipCode:  new FormControl('', [Validators.required]),
      description:  new FormControl('', [Validators.required]),
      uid:  new FormControl(''),
      sdid:  new FormControl('', [Validators.required]),
      options:  new FormArray(
        this.options.map(() => new FormControl(true))
      ),
    });
  }

  getDesk(id: string) {
    firstValueFrom(this.dao.getDeskById(id)).then(
      (desk) => {
        this.desk = desk[0];
        this.images = Object?.values(this.desk.images);
        this.setAddFormValues(this.desk);
        console.log(this.desk);
        firstValueFrom(this.dao.getUserById(this.desk.user_id)).then(
          (user) => {
          }
        )
      }
    )
  }

  setAddFormValues(des: DeskModel) {
    this.addDeskForm.patchValue({
      numberPlaces: des.numberPlaces,
      address: des.adress,
      price: des.price,
      city: des.city,
      zipCode: des.zipCode,
      description: des.description,
      uid: this.userConnected.id,
      sdid: des,
      options: [],
    });
    const valuesArray = this.options.map(option => {
      return des.options.hasOwnProperty(option.id);
    });

    this.addDeskForm.get('options').patchValue(valuesArray);
  }


  initializeOptions(options, backendOptions) {
    console.log(options, backendOptions);
    return options.map(option => {
      const isChecked = backendOptions.hasOwnProperty(option.id);
      return new FormControl(isChecked);
    });
  }
}
