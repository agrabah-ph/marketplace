
import { Injectable } from '@angular/core';
import { HttpInterceptor,HttpRequest,HttpHandler,HttpEvent } from '@angular/common/http';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';
import { AuthenticationService } from 'src/app/services/authentication.service';

@Injectable()
export class ApiInterceptor implements HttpInterceptor {

    constructor(public authService: AuthenticationService) { }

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    // Apply the headers
    req = req.clone({
      setHeaders: {
        'Authorization': `Bearer ${this.authService.getAccessToken()}`
      }
    });
 
    // Also handle errors globally
    return next.handle(req).pipe(
      tap(x => x, err => {
        // Handle this err
        console.error(`Error performing request, status code = ${err.status}`);
        if (err.status = 402) {
          // this.authService.logout();
        }
      })
    );
  }
}