import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { AuthenticationService } from 'src/app/services/authentication.service';

import  { UserControllerService } from 'src/app/api/services';

interface Credential {
  username?: string;
  usercode?: string;
  remember: boolean;
}


@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  
  
  form: FormGroup;
  public loginInvalid: boolean;
  private formSubmitAttempt: boolean;
  private returnUrl: string;

  title = 'Competency Profiling and Assessment';

//  userProfiles: Observable<UserProfilesWithRelations[]>;

  credential: Credential = {
    remember: false
  };
  

  constructor(
    private fb: FormBuilder,
    private route: ActivatedRoute,
    private router: Router,
    private authService: AuthenticationService,
    private user: UserControllerService
    
//    private userProfilesService: UserProfilesControllerService
  ) { 

  }

  ngOnInit() {
    this.returnUrl = this.route.snapshot.queryParams.returnUrl || '';
    this.form = this.fb.group({
      username: ['',Validators.email],
      password: ['',Validators.required]
    });
    if (this.authService.currentUserValue.token != null) {
      console.log(this.authService.currentUserValue);
      console.log(this.returnUrl)
      this.router.navigate([this.returnUrl]);
    }
    
  }

  onSubmit() {
    this.loginInvalid = false;
    this.formSubmitAttempt = false;
    if (this.form.valid) {
        let username = this.form.get('username')?.value;
        let password = this.form.get('password')?.value;
        this.login(username, password).subscribe(
          (response) => { 
            console.log()
            this.router.navigate([this.returnUrl]);
          },
          err => this.loginInvalid = true
        );

    } else {
      this.formSubmitAttempt = true;
    }
  }

  login(username: string, password: string) {

    return this.user.login({
        "body": {
          "email": username,
          "password": password
        }
      })
        .pipe(map(user => {
            console.log(user);
            // store user details and jwt token in local storage to keep user logged in between page refreshes
            localStorage.setItem('currentUser', JSON.stringify(user));
            this.authService.setUser(user);
            // this.currentUserSubject.next(user);
            return user;
        }));

}

  logout() {

  }
  getProfiles() {
//    this.userProfiles = this.userProfilesService.userProfilesControllerFind()
  }
}
