/* tslint:disable */
/* eslint-disable */

/**
 * (Schema options: { includeRelations: true })
 */
export interface FarmerWithRelations {
  address: string;
  address2?: string;
  barangay: string;
  birthdate: string;
  city: string;
  civil: string;
  education: string;
  farmArea: number;
  farmLot: number;
  farmName: string;
  farmSince: number;
  farmType?: string;
  firstName: string;
  gender: string;
  id?: string;
  isAqua?: boolean;
  isBen?: boolean;
  isConventional?: boolean;
  isCrop?: boolean;
  isDairy?: boolean;
  isFruit?: boolean;
  isHousehold?: boolean;
  isInd?: boolean;
  isIntegrated?: boolean;
  isIrrigated?: boolean;
  isMeat?: boolean;
  isMonoculture?: boolean;
  isNatural?: boolean;
  isOrgMember?: boolean;
  isOrganic?: boolean;
  isPoultry?: boolean;
  isPwd?: boolean;
  isSustainable?: boolean;
  lastName: string;
  livelihood?: string;
  middleName: string;
  mobile: string;
  mother: string;
  orgName?: string;
  postalCode?: number;
  prefix?: string;
  province: string;
  religion: string;
  suffix?: string;

  [key: string]: any;
}
