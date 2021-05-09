import {AuthenticationComponent} from '@loopback/authentication';
import {
  JWTAuthenticationComponent,

  TokenServiceBindings, UserServiceBindings
} from '@loopback/authentication-jwt';
import {
  AuthorizationBindings, AuthorizationComponent,
  AuthorizationDecision, AuthorizationOptions
} from '@loopback/authorization';
import {BootMixin} from '@loopback/boot';
import {ApplicationConfig} from '@loopback/core';
import {RepositoryMixin} from '@loopback/repository';
import {RestApplication} from '@loopback/rest';
import {
  RestExplorerBindings,
  RestExplorerComponent
} from '@loopback/rest-explorer';
import {ServiceMixin} from '@loopback/service-proxy';
import crypto from 'crypto';
import path from 'path';
import {CasbinAuthorizationComponent} from './components/casbin-authorization';
import {DbDataSource} from './datasources';
import {MySequence} from './sequence';
import {JWTService, RegistryUserService} from './services';

const authOptions: AuthorizationOptions = {
  precedence: AuthorizationDecision.DENY,
  defaultDecision: AuthorizationDecision.DENY,
};





export {ApplicationConfig};


export class LoopbackIoApplication extends BootMixin(
  ServiceMixin(RepositoryMixin(RestApplication)),
) {
  constructor(options: ApplicationConfig = {}) {
    super(options);


    // Bind authentication component related elements
    this.component(AuthenticationComponent);
    this.component(JWTAuthenticationComponent);

    this.configure(AuthorizationBindings.COMPONENT).to(authOptions);
    this.component(AuthorizationComponent);

    this.component(CasbinAuthorizationComponent);

    this.setUpBindings();

    // Bind datasource
    this.dataSource(DbDataSource, UserServiceBindings.DATASOURCE_NAME);

    // Set up the custom sequence
    this.sequence(MySequence);

    // Set up default home page
    this.static('/', path.join(__dirname, '../public'));

    // Customize @loopback/rest-explorer configuration here
    this.configure(RestExplorerBindings.COMPONENT).to({
      path: '/explorer',
    });
    this.component(RestExplorerComponent);

    this.projectRoot = __dirname;
    // Customize @loopback/boot Booter Conventions here
    this.bootOptions = {
      controllers: {
        // Customize ControllerBooter Conventions here
        dirs: ['controllers'],
        extensions: ['.controller.js'],
        nested: true,
      },
    };
  }


  setUpBindings(): void {

    this.bind(TokenServiceBindings.TOKEN_SERVICE).toClass(JWTService);

    this.bind(UserServiceBindings.USER_SERVICE).toClass(RegistryUserService);

    // Use JWT secret from JWT_SECRET environment variable if set
    // otherwise create a random string of 64 hex digits
    const secret =
      process.env.JWT_SECRET ?? crypto.randomBytes(32).toString('hex');
    this.bind(TokenServiceBindings.TOKEN_SECRET).to(secret);
  }
}
