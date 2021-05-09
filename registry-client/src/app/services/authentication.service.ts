import { Injectable } from '@angular/core';
import { CanActivate, Router } from '@angular/router';
import { BehaviorSubject, Observable } from 'rxjs';
import { map } from 'rxjs/operators';


export interface User { 
    token?: string;
}

@Injectable({ providedIn: 'root' })
export class AuthenticationService  implements CanActivate {
    private currentUserSubject: BehaviorSubject<User>;
    public currentUser: Observable<User>;

    constructor(
        private router: Router
        ) {

        this.currentUserSubject = new BehaviorSubject<User>(JSON.parse(localStorage.getItem('currentUser') ?? '{}'));
        this.currentUser = this.currentUserSubject.asObservable();
    }

    public get currentUserValue(): User {
        return this.currentUserSubject.value;
    }

    public getAccessToken():string {
        return this.currentUserSubject && this.currentUserSubject.value && this.currentUserSubject.value.token 
          ? this.currentUserSubject.value.token: '';
    }

    canActivate(): Observable<boolean> {
        if (this.currentUserSubject.value != null ) {
            return new Observable<boolean>(subscriber => {
                subscriber.next(true);
            });
        }

        return new Observable<boolean>(subscriber => {
            this.router.navigate(['/401']);
            subscriber.next(false);
        });
    }

    public setUser(user: User) {
        this.currentUserSubject.next(user);
    }

    logout() {
        // remove user from local storage to log user out
        localStorage.removeItem('currentUser');
        this.currentUserSubject.next({});
        this.router.navigate(['/login']);
    }
}