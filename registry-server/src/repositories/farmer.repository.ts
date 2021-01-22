import {DefaultCrudRepository} from '@loopback/repository';
import {Farmer, FarmerRelations} from '../models';
import {AgdocdbDataSource} from '../datasources';
import {inject} from '@loopback/core';

export class FarmerRepository extends DefaultCrudRepository<
  Farmer,
  typeof Farmer.prototype.id,
  FarmerRelations
> {
  constructor(
    @inject('datasources.agdocdb') dataSource: AgdocdbDataSource,
  ) {
    super(Farmer, dataSource);
  }
}
