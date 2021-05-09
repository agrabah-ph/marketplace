import {Entity, model, property} from '@loopback/repository';

@model()
export class Team extends Entity {
  @property({
    type: 'number',
    id: true,
    generated: false,
    updateOnly: true
  })
  id: number;

  @property({
    type: 'array',
    itemType: 'number',
    required: true,
  })
  memberIds: number[];

  @property({
    type: 'string',
  })
  ownerId?: string;

  constructor(data?: Partial<Team>) {
    super(data);
  }
}

export interface TeamRelations {
  // describe navigational properties here
}

export type TeamWithRelations = Team & TeamRelations;
