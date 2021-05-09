// ---------- ADD IMPORTS -------------
import {authenticate} from '@loopback/authentication';
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
import {authorize} from '@loopback/authorization';
import {basicAuthorization} from '../services';

import {FarmingActivity} from '../models';
import {FarmingActivityRepository} from '../repositories';

// ------------------------------------
@authenticate('jwt')
export class FarmingActivityController {
  constructor(
    @repository(FarmingActivityRepository)
    public farmingActivityRepository: FarmingActivityRepository,
  ) { }

  @post('/farming-activities')
  @response(200, {
    description: 'FarmingActivity model instance',
    content: {'application/json': {schema: getModelSchemaRef(FarmingActivity)}},
  })
  async create(
    @requestBody({
      content: {
        'application/json': {
          schema: getModelSchemaRef(FarmingActivity, {
            title: 'NewFarmingActivity',
            exclude: ['id'],
          }),
        },
      },
    })
    farmingActivity: Omit<FarmingActivity, 'id'>,
  ): Promise<FarmingActivity> {
    return this.farmingActivityRepository.create(farmingActivity);
  }

  @get('/farming-activities/count')
  @response(200, {
    description: 'FarmingActivity model count',
    content: {'application/json': {schema: CountSchema}},
  })
  async count(
    @param.where(FarmingActivity) where?: Where<FarmingActivity>,
  ): Promise<Count> {
    return this.farmingActivityRepository.count(where);
  }

  @authorize({allowedRoles: ['customer'], voters: [basicAuthorization]})
  @get('/farming-activities')
  @response(200, {
    description: 'Array of FarmingActivity model instances',
    content: {
      'application/json': {
        schema: {
          type: 'array',
          items: getModelSchemaRef(FarmingActivity, {includeRelations: true}),
        },
      },
    },
  })
  async find(
    @param.filter(FarmingActivity) filter?: Filter<FarmingActivity>,
  ): Promise<FarmingActivity[]> {
    return this.farmingActivityRepository.find(filter);
  }

  @patch('/farming-activities')
  @response(200, {
    description: 'FarmingActivity PATCH success count',
    content: {'application/json': {schema: CountSchema}},
  })
  async updateAll(
    @requestBody({
      content: {
        'application/json': {
          schema: getModelSchemaRef(FarmingActivity, {partial: true}),
        },
      },
    })
    farmingActivity: FarmingActivity,
    @param.where(FarmingActivity) where?: Where<FarmingActivity>,
  ): Promise<Count> {
    return this.farmingActivityRepository.updateAll(farmingActivity, where);
  }

  @get('/farming-activities/{id}')
  @response(200, {
    description: 'FarmingActivity model instance',
    content: {
      'application/json': {
        schema: getModelSchemaRef(FarmingActivity, {includeRelations: true}),
      },
    },
  })
  async findById(
    @param.path.string('id') id: string,
    @param.filter(FarmingActivity, {exclude: 'where'}) filter?: FilterExcludingWhere<FarmingActivity>
  ): Promise<FarmingActivity> {
    return this.farmingActivityRepository.findById(id, filter);
  }

  @patch('/farming-activities/{id}')
  @response(204, {
    description: 'FarmingActivity PATCH success',
  })
  async updateById(
    @param.path.string('id') id: string,
    @requestBody({
      content: {
        'application/json': {
          schema: getModelSchemaRef(FarmingActivity, {partial: true}),
        },
      },
    })
    farmingActivity: FarmingActivity,
  ): Promise<void> {
    await this.farmingActivityRepository.updateById(id, farmingActivity);
  }

  @put('/farming-activities/{id}')
  @response(204, {
    description: 'FarmingActivity PUT success',
  })
  async replaceById(
    @param.path.string('id') id: string,
    @requestBody() farmingActivity: FarmingActivity,
  ): Promise<void> {
    await this.farmingActivityRepository.replaceById(id, farmingActivity);
  }

  @del('/farming-activities/{id}')
  @response(204, {
    description: 'FarmingActivity DELETE success',
  })
  async deleteById(@param.path.string('id') id: string): Promise<void> {
    await this.farmingActivityRepository.deleteById(id);
  }
}
