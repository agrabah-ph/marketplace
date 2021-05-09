import { Component, OnInit } from '@angular/core';
import { BreakpointObserver, Breakpoints } from '@angular/cdk/layout';
import { Observable } from 'rxjs';
import { map, shareReplay } from 'rxjs/operators';
import { Router } from '@angular/router';
import { AuthenticationService } from 'src/app/services/authentication.service';


@Component({
  selector: 'app-navigation',
  templateUrl: './navigation.component.html',
  styleUrls: ['./navigation.component.scss']
})
export class NavigationComponent implements OnInit {
  title = 'Agrabah Marketplace';
  isHandset$: Observable<boolean> = this.breakpointObserver.observe(Breakpoints.Handset)
    .pipe(
      map(result => result.matches),
      shareReplay()
    );

  constructor(private breakpointObserver: BreakpointObserver,
    private authService: AuthenticationService,
    private router: Router
    ) {}
    ngOnInit() {
      if (this.authService.currentUserValue != null) {
        console.log(this.authService.currentUserValue)
      }
    }
    goHome() {
      this.router.navigate([''])
    }

    logout() {
      this.authService.logout();
    }

    isLoggedIn() {
      return this.authService.currentUserValue.token
    }
}
