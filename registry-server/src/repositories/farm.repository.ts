import {inject} from '@loopback/core';
import {DefaultCrudRepository} from '@loopback/repository';
import {DbDataSource} from '../datasources';
import {Farm, FarmRelations} from '../models';

export class FarmRepository extends DefaultCrudRepository<
  Farm,
  typeof Farm.prototype.id,
  FarmRelations
> {
  constructor(
    @inject('datasources.db') dataSource: DbDataSource,
  ) {
    super(Farm, dataSource);
  }
}
