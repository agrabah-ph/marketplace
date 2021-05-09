import {Entity, model, property} from '@loopback/repository';

@model({settings: {strict: false}})
export class FarmingActivity extends Entity {
  @property({
    type: 'string',
    required: true,
  })
  name: string;

  @property({
    type: 'string',
    id: true,
    generated: true,
  })
  id?: string;

  // Define well-known properties here

  // Indexer property to allow additional data
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  [prop: string]: any;

  constructor(data?: Partial<FarmingActivity>) {
    super(data);
  }
}

export interface FarmingActivityRelations {
  // describe navigational properties here
}

export type FarmingActivityWithRelations = FarmingActivity & FarmingActivityRelations;
