import {
  Count,
  CountSchema,
  Filter,
  // FilterExcludingWhere,
  repository,
  Where,
} from '@loopback/repository';
import {
  post,
  param,
  get,
  getModelSchemaRef,
  getWhereSchemaFor,
  getFilterSchemaFor,
  patch,
  put,
  del,
  requestBody,
} from '@loopback/rest';
import { Farmer } from '../models';
import { FarmerRepository } from '../repositories';

export class FarmerController {
  constructor(
    @repository(FarmerRepository)
    public farmerRepository: FarmerRepository,
  ) { }

  @post('/farmers', {
    responses: {
      '200': {
        description: 'Farmer model instance',
        content: { 'application/json': { schema: getModelSchemaRef(Farmer) } },
      },
    },
  })
  async create(
    @requestBody({
      content: {
        'application/json': {
          schema: getModelSchemaRef(Farmer, {
            title: 'NewFarmer',
            exclude: ['id'],
          }),
        },
      },
    })
    farmer: Omit<Farmer, 'id'>,
  ): Promise<Farmer> {
    return this.farmerRepository.create(farmer);
  }

  @get('/farmers/count', {
    responses: {
      '200': {
        description: 'Farmer model count',
        content: { 'application/json': { schema: CountSchema } },
      },
    },
  })
  async count(
    @param.query.object('where', getWhereSchemaFor(Farmer)) where?: Where<Farmer>, //@param.where(Farmer)
  ): Promise<Count> {
    return this.farmerRepository.count(where);
  }

  @get('/farmers', {
    responses: {
      '200': {
        description: 'Array of Farmer model instances',
        content: {
          'application/json': {
            schema: {
              type: 'array',
              items: getModelSchemaRef(Farmer, { includeRelations: true }),
            },
          },
        },
      },
    },
  })
  async find(
    @param.query.object('filter', getFilterSchemaFor(Farmer)) filter?: Filter<Farmer>, // @param.filter(Farmer)
  ): Promise<Farmer[]> {
    console.log(filter);
    return this.farmerRepository.find(filter);
  }

  @patch('/farmers', {
    responses: {
      '200': {
        description: 'Farmer PATCH success count',
        content: { 'application/json': { schema: CountSchema } },
      },
    },
  })
  async updateAll(
    @requestBody({
      content: {
        'application/json': {
          schema: getModelSchemaRef(Farmer, { partial: true }),
        },
      },
    })
    farmer: Farmer,
    where?: Where<Farmer>, // @param.where(Farmer)
  ): Promise<Count> {
    return this.farmerRepository.updateAll(farmer, where);
  }

  @get('/farmers/{id}', {
    responses: {
      '200': {
        description: 'Farmer model instance',
        content: {
          'application/json': {
            schema: getModelSchemaRef(Farmer, { includeRelations: true }),
          },
        },
      },
    },
  })
  async findById(
    @param.path.string('id') id: string,
    // @param.filter(Farmer, { exclude: 'where' }) filter?: FilterExcludingWhere<Farmer>
    filter?: Filter<Farmer>
  ): Promise<Farmer> {
    return this.farmerRepository.findById(id, filter);
  }

  @patch('/farmers/{id}', {
    responses: {
      '204': {
        description: 'Farmer PATCH success',
      },
    },
  })
  async updateById(
    @param.path.string('id') id: string,
    @requestBody({
      content: {
        'application/json': {
          schema: getModelSchemaRef(Farmer, { partial: true }),
        },
      },
    })
    farmer: Farmer,
  ): Promise<void> {
    await this.farmerRepository.updateById(id, farmer);
  }

  @put('/farmers/{id}', {
    responses: {
      '204': {
        description: 'Farmer PUT success',
      },
    },
  })
  async replaceById(
    @param.path.string('id') id: string,
    @requestBody() farmer: Farmer,
  ): Promise<void> {
    await this.farmerRepository.replaceById(id, farmer);
  }

  @del('/farmers/{id}', {
    responses: {
      '204': {
        description: 'Farmer DELETE success',
      },
    },
  })
  async deleteById(@param.path.string('id') id: string): Promise<void> {
    await this.farmerRepository.deleteById(id);
  }
}
