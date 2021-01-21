import { inject, lifeCycleObserver, LifeCycleObserver } from '@loopback/core';
import { juggler } from '@loopback/repository';

import * as config from './agdocdb.datasource.config.json';

// 'mongodb://strata:78IX7.563sQAk&S@docdb-2021-01-17-12-53-25.cluster-cf2unjdwm1lm.ap-southeast-1.docdb.amazonaws.com:27017/?ssl=true&ssl_ca_certs=rds-combined-ca-bundle.pem&replicaSet=rs0&readPreference=secondaryPreferred&retryWrites=false',

/*
  url: 'mongodb://strata:Demo_admin1@127.0.0.1:27017/?ssl=true&ssl_ca_certs=rds-combined-ca-bundle.pem&retryWrites=false',

  host: 'localhost',
  port: 27017,
  user: 'strata',
  password: '78IX7.563sQAk&S',
  database: 'docdb-2021-01-17-12-53-25',

  ssl: true,
  sslValidate: true,
  checkServerIdentity: false,
  sslCA: "rds-combined-ca-bundle.pem",

,
  useNewUrlParser: true

  */


// Observe application's life cycle to disconnect the datasource when
// application is stopped. This allows the application to be shut down
// gracefully. The `stop()` method is inherited from `juggler.DataSource`.
// Learn more at https://loopback.io/doc/en/lb4/Life-cycle.html
@lifeCycleObserver('datasource')
export class AgdocdbDataSource extends juggler.DataSource
  implements LifeCycleObserver {
  static dataSourceName = 'agdocdb';
  static readonly defaultConfig = config;

  constructor(
    @inject('datasources.config.agdocdb', { optional: true })
    dsConfig: object = config,
  ) {
    super(dsConfig);
  }
}
