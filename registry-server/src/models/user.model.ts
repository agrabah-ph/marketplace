import {UserCredentials} from '@loopback/authentication-jwt';
import {Entity, hasOne, model, property, hasMany} from '@loopback/repository';
import {Team} from './team.model';

@model({
  settings: {
    indexes: {
      uniqueEmail: {
        keys: {
          email: 1,
        },
        options: {
          unique: true,
        },
      },
    },
  },
})
export class User extends Entity {
  @property({
    type: 'string',
    id: true,
  })
  id: string;

  @property({
    type: 'string',
    required: true,
  })
  email: string;

  @property({
    type: 'string',
  })
  firstName?: string;

  @property({
    type: 'string',
  })
  lastName?: string;


  @hasOne(() => UserCredentials)
  userCredentials: UserCredentials;


  @property({
    type: 'array',
    itemType: 'string',
  })
  roles?: string[];

  @property({
    type: 'string',
  })
  resetKey?: string;

  @property({
    type: 'number',
  })
  resetCount: number;

  @property({
    type: 'string',
  })
  resetTimestamp: string;

  @property({
    type: 'string',
  })
  resetKeyTimestamp: string;

  @hasMany(() => Team, {keyTo: 'ownerId'})
  teams: Team[];

  constructor(data?: Partial<User>) {
    super(data);
  }
}
