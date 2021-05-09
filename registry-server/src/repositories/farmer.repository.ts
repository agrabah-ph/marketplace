import {inject, Getter} from '@loopback/core';
import {DefaultCrudRepository, repository, HasManyRepositoryFactory} from '@loopback/repository';
import {DbDataSource} from '../datasources';
import {Farmer, FarmerRelations, Farm} from '../models';
import {FarmRepository} from './farm.repository';

export class FarmerRepository extends DefaultCrudRepository<
  Farmer,
  typeof Farmer.prototype.id,
  FarmerRelations
> {

  public readonly farms: HasManyRepositoryFactory<Farm, typeof Farmer.prototype.id>;

  constructor(
    @inject('datasources.db') dataSource: DbDataSource, @repository.getter('FarmRepository') protected farmRepositoryGetter: Getter<FarmRepository>,
  ) {
    super(Farmer, dataSource);
    this.farms = this.createHasManyRepositoryFactoryFor('farms', farmRepositoryGetter,);
    this.registerInclusionResolver('farms', this.farms.inclusionResolver);
  }
}
