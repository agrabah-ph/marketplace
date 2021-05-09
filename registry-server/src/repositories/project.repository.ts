import {inject, Getter} from '@loopback/core';
import {DefaultCrudRepository, repository, BelongsToAccessor} from '@loopback/repository';
import {DbDataSource} from '../datasources';
import {Project, ProjectRelations, User} from '../models';
import {UserRepository} from './user.repository';

export class ProjectRepository extends DefaultCrudRepository<
  Project,
  typeof Project.prototype.id,
  ProjectRelations
> {

  public readonly owner: BelongsToAccessor<User, typeof Project.prototype.id>;

  constructor(
    @inject('datasources.db') dataSource: DbDataSource, @repository.getter('UserRepository') protected userRepositoryGetter: Getter<UserRepository>,
  ) {
    super(Project, dataSource);
    this.owner = this.createBelongsToAccessorFor('owner', userRepositoryGetter,);
    this.registerInclusionResolver('owner', this.owner.inclusionResolver);
  }
}
