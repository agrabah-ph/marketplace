import {Entity, model, property, belongsTo} from '@loopback/repository';
import {User} from './user.model';

@model()
export class Project extends Entity {
  @property({
    type: 'number',
    id: true,
    generated: false,
    updateOnly: true
  })
  id: number;

  @property({
    type: 'string',
  })
  name?: string;

  @property({
    type: 'number',
  })
  balance: number;

  @belongsTo(() => User)
  ownerId: string;

  constructor(data?: Partial<Project>) {
    super(data);
  }
}

export interface ProjectRelations {
  // describe navigational properties here
}

export type ProjectWithRelations = Project & ProjectRelations;
