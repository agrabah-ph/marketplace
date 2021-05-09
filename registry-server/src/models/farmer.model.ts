import {Entity, model, property, hasMany} from '@loopback/repository';
import {Farm} from './farm.model';

@model({settings: {strict: false}})
export class Farmer extends Entity {
  @property({
    type: 'string',
    id: true,
    generated: true,
  })
  id?: string;

  @property({
    type: 'string',
  })
  prefix?: string;

  @property({
    type: 'string',
    required: true,
  })
  firstName: string;

  @property({
    type: 'string',
    required: true,
  })
  middleName: string;

  @property({
    type: 'string',
    required: true,
  })
  lastName: string;

  @property({
    type: 'string',
  })
  suffix?: string;

  @property({
    type: 'string',
    required: true,
  })
  mobile: string;

  @property({
    type: 'string',
    required: true,
  })
  gender: string;

  @property({
    type: 'string',
    required: true,
  })
  civil: string;

  @property({
    type: 'date',
    required: true,
  })
  birthdate: string;

  @property({
    type: 'string',
    required: true,
  })
  religion: string;

  @property({
    type: 'string',
    required: true,
  })
  mother: string;

  @property({
    type: 'boolean',
    default: false,
  })
  isHousehold?: boolean;

  @property({
    type: 'boolean',
    default: false,
  })
  isPwd?: boolean;

  @property({
    type: 'boolean',
    default: false,
  })
  isBen?: boolean;

  @property({
    type: 'boolean',
    default: false,
  })
  isInd?: boolean;

  @property({
    type: 'string',
    required: true,
  })
  address: string;

  @property({
    type: 'string',
  })
  address2?: string;

  @property({
    type: 'string',
    required: true,
  })
  barangay: string;

  @property({
    type: 'string',
    required: true,
  })
  province: string;

  @property({
    type: 'string',
    required: true,
  })
  city: string;

  @property({
    type: 'number',
  })
  postalCode?: number;

  @property({
    type: 'string',
    required: true,
  })
  education: string;

  @hasMany(() => Farm, {keyTo: 'ownerId'})
  farms: Farm[];
  // Define well-known properties here

  // Indexer property to allow additional data
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  [prop: string]: any;

  constructor(data?: Partial<Farmer>) {
    super(data);
  }
}

export interface FarmerRelations {
  // describe navigational properties here
}

export type FarmerWithRelations = Farmer & FarmerRelations;
