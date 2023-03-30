export interface DeskModel {
  price: number,
  address: string,
  adress?: string,
  city: string,
  zipCode: number,
  description: string,
  numberPlaces: number,
  uid: string,
  sdid: number,
  averageNote?: number,

  tax?: number,

  id?: number;
  user_id?: string;

}
