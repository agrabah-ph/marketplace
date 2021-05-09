import {Entity, model, property} from '@loopback/repository';

@model()
export class Farm extends Entity {
  @property({
    type: 'number',
    id: true,
    generated: false,
    required: true,
  })
  id: number;

  @property({
    type: 'date',
    required: true,
  })
  startDate: string;

  @property({
    type: 'date',
    required: true,
  })
  endDate: string;

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

  @property({
    type: 'string',
  })
  ownerId?: string;

  constructor(data?: Partial<Farm>) {
    super(data);
  }
}

export interface FarmRelations {
  // describe navigational properties here
}

export type FarmWithRelations = Farm & FarmRelations;
