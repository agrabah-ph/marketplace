// Copyright IBM Corp. 2020. All Rights Reserved.
// Node module: @loopback/example-access-control-migration
// This file is licensed under the MIT License.
// License text available at https://opensource.org/licenses/MIT

import * as casbin from 'casbin';
import path from 'path';

const POLICY_PATHS = {
  admin: './../../../../fixtures/casbin/rbac_policy.admin.csv',
  owner: './../../../../fixtures/casbin/rbac_policy.owner.csv',
  community: './../../../../fixtures/casbin/rbac_policy.community_member.csv',
};

export async function getCasbinEnforcerByName(
  name: string,
): Promise<casbin.Enforcer | undefined> {
  const CASBIN_ENFORCERS: {[key: string]: Promise<casbin.Enforcer>} = {
    admin: createEnforcerByRole(POLICY_PATHS.admin),
    owner: createEnforcerByRole(POLICY_PATHS.owner),
    community: createEnforcerByRole(POLICY_PATHS.community),
  };
  if (Object.prototype.hasOwnProperty.call(CASBIN_ENFORCERS, name))
    return CASBIN_ENFORCERS[name];
  return undefined;
}

export async function createEnforcerByRole(
  policyPath: string,
): Promise<casbin.Enforcer> {
  const conf = path.resolve(
    __dirname,
    './../../../../fixtures/casbin/rbac_model.conf',
  );
  const policy = path.resolve(__dirname, policyPath);
  return casbin.newEnforcer(conf, policy);
}
