import { Injectable } from '@angular/core';
import {
  HttpEvent, HttpInterceptor, HttpHandler, HttpRequest, HttpErrorResponse
} from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import {Dao} from "./dao";

@Injectable()
export class TokenInterceptor implements HttpInterceptor {

  constructor(private dao: Dao) {}

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {

    const authReq = req.clone({
      headers: req.headers.set('Authorization', `Bearer ${this.dao.getAccessToken()}`)
    });

    return next.handle(authReq).pipe(
      catchError((error: HttpErrorResponse) => {
        if (error.status === 401) {
          this.dao.logout();
        }
        return throwError(error);
      })
    );
  }
}
