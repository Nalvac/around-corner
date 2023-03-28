import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class HttpService {

    private API_URL = 'https://localhost:8000';

    constructor(
      private http: HttpClient
    ) {}
  
    get(
      url: string,
      input?: any,
      txtResponse: boolean = false,
      headers: { [headerKey: string]: string } = {},
    ): Observable<any> {
  
      let params: HttpParams = this.getHttpParams(input, false);
      let baseHeaders: HttpHeaders = this.getHeaders();
      let allHeaders: HttpHeaders = this.setAdditionalHeaders(baseHeaders, headers || {});
      let options = {headers: allHeaders, params: params};
  
      if (txtResponse) {
      }
  
      return this.http
        .get(`${this.API_URL}/${url}`, options)
        .pipe();
    }
  
    post(
      url: string,
      input?: any,
      txtResponse: boolean = false,
    ): Observable<any> {
      let headers: HttpHeaders = this.getHeaders();
      let options = { headers };
  
      if (txtResponse) {
      }
  
      return this.http
        .post(`${this.API_URL}/${url}`, input, options)
        .pipe();
    }
  
    delete(
      url: string,
    ): Observable<any> {
      let headers: HttpHeaders = this.getHeaders();
      let options = { headers };
  
  
  
      return this.http
        .delete(`${this.API_URL}/${url}`, options)
        .pipe();
    }
  
    private getHttpParams(
      input: any,
      jsonContent: boolean = true,
      myFitSession: boolean = false,
    ): HttpParams {
      let params: HttpParams = new HttpParams();
      if (input && !jsonContent) {
        Object.keys(input).forEach((key) => params = params.append(key, input[key]));
      }
      if (myFitSession) {
        params = params.append('token', this.getJWT());
      }
      return params;
    }
  
    private setAdditionalHeaders(baseHeaders: HttpHeaders, additionalHeaders: { [headerKey: string]: string }) {
      return Object.keys(additionalHeaders).reduce(
        (headers: HttpHeaders, nextHeaderKey: string) => {
          return headers.append(nextHeaderKey, additionalHeaders[nextHeaderKey]);
        },
        baseHeaders,
      );
    }
  
    private getHeaders(): HttpHeaders {
      return new HttpHeaders({'Content-Type': 'application/json', 'Authorization': `Bearer ${this.getJWT()}`})
    }
  
    private getJWT(): string {
      let returnToken: string | null = sessionStorage.getItem('token');
  
      return returnToken == null ? '' : returnToken;
    }
}
