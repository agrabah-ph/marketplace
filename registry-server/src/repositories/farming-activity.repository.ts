import {inject} from '@loopback/core';
import {DefaultCrudRepository} from '@loopback/repository';
import {DbDataSource} from '../datasources';
import {FarmingActivity, FarmingActivityRelations} from '../models';

export class FarmingActivityRepository extends DefaultCrudRepository<
  FarmingActivity,
  typeof FarmingActivity.prototype.id,
  FarmingActivityRelations
> {
  constructor(
    @inject('datasources.db') dataSource: DbDataSource,
  ) {
    super(FarmingActivity, dataSource);
  }
}
