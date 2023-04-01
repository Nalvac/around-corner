export interface BookModel {
  created:  {date: string, timezone_type: number, timezone: string},
  desk: number,
  endDate: {date: string, timezone_type: number, timezone: string},
  id: number,
  note: any,
  opinion: string,
  price: number,
  startDate: {date: string, timezone_type: number, timezone: string}
  user: number,
  adress: string;
}
