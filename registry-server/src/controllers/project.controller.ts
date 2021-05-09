import {authenticate} from '@loopback/authentication';
import {authorize} from '@loopback/authorization';
import {
  Count,
  CountSchema,
  Filter,
  FilterExcludingWhere,
  repository,
  Where
} from '@loopback/repository';
import {
  del, get,
  getModelSchemaRef, param,
  patch, post,
  put,
  requestBody,
  response
} from '@loopback/rest';
import _ from 'lodash';
import {assignProjectInstanceId} from '../components/casbin-authorization';
import {Project} from '../models';
import {ProjectRepository} from '../repositories';


const RESOURCE_NAME = 'farm';
const ACL_PROJECT = {
  'view-all': {
    resource: `${RESOURCE_NAME}*`,
    scopes: ['view-all'],
    allowedRoles: ['admin'],
  },
  'show-balance': {
    resource: RESOURCE_NAME,
    scopes: ['show-balance'],
    allowedRoles: ['owner', 'community'],
    voters: [assignProjectInstanceId],
  },
  donate: {
    resource: RESOURCE_NAME,
    scopes: ['donate'],
    allowedRoles: ['admin', 'owner', 'community'],
    voters: [assignProjectInstanceId],
  },
  withdraw: {
    resource: RESOURCE_NAME,
    scopes: ['withdraw'],
    allowedRoles: ['owner'],
    voters: [assignProjectInstanceId],
  },
};

export class ProjectController {
  constructor(
    @repository(ProjectRepository)
    public projectRepository: ProjectRepository,
  ) { }

  @post('/projects')
  @response(200, {
    description: 'Project model instance',
    content: {'application/json': {schema: getModelSchemaRef(Project)}},
  })
  async create(
    @requestBody({
      content: {
        'application/json': {
          schema: getModelSchemaRef(Project, {
            title: 'NewProject',

          }),
        },
      },
    })
    project: Project,
  ): Promise<Project> {
    return this.projectRepository.create(project);
  }

  @get('/projects/count')
  @response(200, {
    description: 'Project model count',
    content: {'application/json': {schema: CountSchema}},
  })
  async count(
    @param.where(Project) where?: Where<Project>,
  ): Promise<Count> {
    return this.projectRepository.count(where);
  }

  @get('/projects')
  @response(200, {
    description: 'Array of Project model instances',
    content: {
      'application/json': {
        schema: {
          type: 'array',
          items: getModelSchemaRef(Project, {includeRelations: true}),
        },
      },
    },
  })
  async find(
    @param.filter(Project) filter?: Filter<Project>,
  ): Promise<Project[]> {
    return this.projectRepository.find(filter);
  }

  @patch('/projects')
  @response(200, {
    description: 'Project PATCH success count',
    content: {'application/json': {schema: CountSchema}},
  })
  async updateAll(
    @requestBody({
      content: {
        'application/json': {
          schema: getModelSchemaRef(Project, {partial: true}),
        },
      },
    })
    project: Project,
    @param.where(Project) where?: Where<Project>,
  ): Promise<Count> {
    return this.projectRepository.updateAll(project, where);
  }

  @get('/projects/{id}')
  @response(200, {
    description: 'Project model instance',
    content: {
      'application/json': {
        schema: getModelSchemaRef(Project, {includeRelations: true}),
      },
    },
  })
  async findById(
    @param.path.number('id') id: number,
    @param.filter(Project, {exclude: 'where'}) filter?: FilterExcludingWhere<Project>
  ): Promise<Project> {
    return this.projectRepository.findById(id, filter);
  }

  @patch('/projects/{id}')
  @response(204, {
    description: 'Project PATCH success',
  })
  async updateById(
    @param.path.number('id') id: number,
    @requestBody({
      content: {
        'application/json': {
          schema: getModelSchemaRef(Project, {partial: true}),
        },
      },
    })
    project: Project,
  ): Promise<void> {
    await this.projectRepository.updateById(id, project);
  }

  @put('/projects/{id}')
  @response(204, {
    description: 'Project PUT success',
  })
  async replaceById(
    @param.path.number('id') id: number,
    @requestBody() project: Project,
  ): Promise<void> {
    await this.projectRepository.replaceById(id, project);
  }

  @del('/projects/{id}')
  @response(204, {
    description: 'Project DELETE success',
  })
  async deleteById(@param.path.number('id') id: number): Promise<void> {
    await this.projectRepository.deleteById(id);
  }

  // LIST PROJECTS (balance is not public)
  @get('/list-projects', {
    responses: {
      '200': {
        description: 'List all the project model instances without balance',
        content: {
          'application/json': {
            schema: {
              type: 'array',
              items: getModelSchemaRef(Project, {
                title: 'ProjectPublic',
                exclude: ['balance'],
              }),
            },
          },
        },
      },
    },
  })
  async listProjects(): Promise<Omit<Project, 'balance'>[]> {
    const projects = await this.projectRepository.find();
    return projects.map(p => _.omit(p, 'balance'));
  }

  // VIWE ALL PROJECTS (including balance)
  @get('/view-all-projects', {
    responses: {
      '200': {
        description: 'Array of all Project model instances including balance',
        content: {
          'application/json': {
            schema: {
              type: 'array',
              items: getModelSchemaRef(Project),
            },
          },
        },
      },
    },
  })
  @authenticate('jwt')
  @authorize(ACL_PROJECT['view-all'])
  async viewAll(): Promise<Project[]> {
    return this.projectRepository.find();
  }

  // DONATE BY ID
  @patch('/projects/{id}/donate', {
    responses: {
      '204': {
        description: 'Project donate success',
      },
    },
  })
  @authenticate('jwt')
  @authorize(ACL_PROJECT.donate)
  async donateById(
    @param.path.number('id') id: number,
    @param.query.number('amount') amount: number,
  ): Promise<void> {
    const project = await this.projectRepository.findById(id);
    await this.projectRepository.updateById(id, {
      balance: project.balance + amount,
    });
    // TBD: return new balance
  }

  // WITHDRAW BY ID
  @patch('/projects/{id}/withdraw', {
    responses: {
      '204': {
        description: 'Project withdraw success',
      },
    },
  })
  @authenticate('jwt')
  @authorize(ACL_PROJECT.withdraw)
  async withdrawById(
    @param.path.number('id') id: number,
    @param.query.number('amount') amount: number,
  ): Promise<void> {
    const project = await this.projectRepository.findById(id);
    if (project.balance < amount) {
      throw new Error('Balance is not enough.');
    }
    await this.projectRepository.updateById(id, {
      balance: project.balance - amount,
    });
    // TBD: return new balance
  }
}
