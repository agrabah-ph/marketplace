import { Entity, model, property } from '@loopback/repository';

@model({ settings: { strict: false } })
export class Farmer extends Entity {
  @property({
    type: 'string',
  })
  prefix?: string;

  @property({
    type: 'string',
    id: true,
    generated: true,
  })
  id?: string;

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

  @property({
    type: 'string',
  })
  livelihood?: string;

  @property({
    type: 'boolean',
    default: false,
  })
  isAqua?: boolean;

  @property({
    type: 'boolean',
    default: false,
  })
  isCrop?: boolean;

  @property({
    type: 'boolean',
    default: false,
  })
  isDairy?: boolean;

  @property({
    type: 'boolean',
    default: false,
  })
  isFruit?: boolean;

  @property({
    type: 'boolean',
    default: false,
  })
  isMeat?: boolean;

  @property({
    type: 'boolean',
    default: false,
  })
  isPoultry?: boolean;

  @property({
    type: 'string',
  })
  farmType?: string;

  @property({
    type: 'number',
    required: true,
  })
  farmLot: number;

  @property({
    type: 'string',
    required: true,
  })
  farmName: string;

  @property({
    type: 'number',
    required: true,
  })
  farmSince: number;

  @property({
    type: 'number',
    required: true,
  })
  farmArea: number;

  @property({
    type: 'boolean',
    default: false,
  })
  isIrrigated?: boolean;

  @property({
    type: 'boolean',
    default: false,
  })
  isOrgMember?: boolean;

  @property({
    type: 'string',
  })
  orgName?: string;

  @property({
    type: 'boolean',
    default: false,
  })
  isConventional?: boolean;

  @property({
    type: 'boolean',
    default: false,
  })
  isSustainable?: boolean;

  @property({
    type: 'boolean',
    default: false,
  })
  isNatural?: boolean;

  @property({
    type: 'boolean',
    default: false,
  })
  isIntegrated?: boolean;

  @property({
    type: 'boolean',
    default: false,
  })
  isMonoculture?: boolean;

  @property({
    type: 'boolean',
    default: false,
  })
  isOrganic?: boolean;

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
