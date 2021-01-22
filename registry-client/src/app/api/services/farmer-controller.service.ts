/* tslint:disable */
/* eslint-disable */
import { Injectable } from '@angular/core';
import { HttpClient, HttpResponse } from '@angular/common/http';
import { BaseService } from '../base-service';
import { ApiConfiguration } from '../api-configuration';
import { StrictHttpResponse } from '../strict-http-response';
import { RequestBuilder } from '../request-builder';
import { Observable } from 'rxjs';
import { map, filter } from 'rxjs/operators';

import { Farmer } from '../models/farmer';
import { FarmerPartial } from '../models/farmer-partial';
import { FarmerWithRelations } from '../models/farmer-with-relations';
import { NewFarmer } from '../models/new-farmer';

@Injectable({
  providedIn: 'root',
})
export class FarmerControllerService extends BaseService {
  constructor(
    config: ApiConfiguration,
    http: HttpClient
  ) {
    super(config, http);
  }

  /**
   * Path part for operation farmerControllerCount
   */
  static readonly FarmerControllerCountPath = '/farmers/count';

  /**
   * This method provides access to the full `HttpResponse`, allowing access to response headers.
   * To access only the response body, use `count()` instead.
   *
   * This method doesn't expect any request body.
   */
  count$Response(params?: {
    where?: { [key: string]: any };
  }): Observable<StrictHttpResponse<{ 'count'?: number }>> {

    const rb = new RequestBuilder(this.rootUrl, FarmerControllerService.FarmerControllerCountPath, 'get');
    if (params) {
      rb.query('where', params.where, {"style":"deepObject","explode":true});
    }

    return this.http.request(rb.build({
      responseType: 'json',
      accept: 'application/json'
    })).pipe(
      filter((r: any) => r instanceof HttpResponse),
      map((r: HttpResponse<any>) => {
        return r as StrictHttpResponse<{ 'count'?: number }>;
      })
    );
  }

  /**
   * This method provides access to only to the response body.
   * To access the full response (for headers, for example), `count$Response()` instead.
   *
   * This method doesn't expect any request body.
   */
  count(params?: {
    where?: { [key: string]: any };
  }): Observable<{ 'count'?: number }> {

    return this.count$Response(params).pipe(
      map((r: StrictHttpResponse<{ 'count'?: number }>) => r.body as { 'count'?: number })
    );
  }

  /**
   * Path part for operation farmerControllerFindById
   */
  static readonly FarmerControllerFindByIdPath = '/farmers/{id}';

  /**
   * This method provides access to the full `HttpResponse`, allowing access to response headers.
   * To access only the response body, use `findById()` instead.
   *
   * This method doesn't expect any request body.
   */
  findById$Response(params: {
    id: string;
  }): Observable<StrictHttpResponse<FarmerWithRelations>> {

    const rb = new RequestBuilder(this.rootUrl, FarmerControllerService.FarmerControllerFindByIdPath, 'get');
    if (params) {
      rb.path('id', params.id, {});
    }

    return this.http.request(rb.build({
      responseType: 'json',
      accept: 'application/json'
    })).pipe(
      filter((r: any) => r instanceof HttpResponse),
      map((r: HttpResponse<any>) => {
        return r as StrictHttpResponse<FarmerWithRelations>;
      })
    );
  }

  /**
   * This method provides access to only to the response body.
   * To access the full response (for headers, for example), `findById$Response()` instead.
   *
   * This method doesn't expect any request body.
   */
  findById(params: {
    id: string;
  }): Observable<FarmerWithRelations> {

    return this.findById$Response(params).pipe(
      map((r: StrictHttpResponse<FarmerWithRelations>) => r.body as FarmerWithRelations)
    );
  }

  /**
   * Path part for operation farmerControllerReplaceById
   */
  static readonly FarmerControllerReplaceByIdPath = '/farmers/{id}';

  /**
   * This method provides access to the full `HttpResponse`, allowing access to response headers.
   * To access only the response body, use `replaceById()` instead.
   *
   * This method sends `application/json` and handles request body of type `application/json`.
   */
  replaceById$Response(params: {
    id: string;
    body?: Farmer
  }): Observable<StrictHttpResponse<void>> {

    const rb = new RequestBuilder(this.rootUrl, FarmerControllerService.FarmerControllerReplaceByIdPath, 'put');
    if (params) {
      rb.path('id', params.id, {});
      rb.body(params.body, 'application/json');
    }

    return this.http.request(rb.build({
      responseType: 'text',
      accept: '*/*'
    })).pipe(
      filter((r: any) => r instanceof HttpResponse),
      map((r: HttpResponse<any>) => {
        return (r as HttpResponse<any>).clone({ body: undefined }) as StrictHttpResponse<void>;
      })
    );
  }

  /**
   * This method provides access to only to the response body.
   * To access the full response (for headers, for example), `replaceById$Response()` instead.
   *
   * This method sends `application/json` and handles request body of type `application/json`.
   */
  replaceById(params: {
    id: string;
    body?: Farmer
  }): Observable<void> {

    return this.replaceById$Response(params).pipe(
      map((r: StrictHttpResponse<void>) => r.body as void)
    );
  }

  /**
   * Path part for operation farmerControllerDeleteById
   */
  static readonly FarmerControllerDeleteByIdPath = '/farmers/{id}';

  /**
   * This method provides access to the full `HttpResponse`, allowing access to response headers.
   * To access only the response body, use `deleteById()` instead.
   *
   * This method doesn't expect any request body.
   */
  deleteById$Response(params: {
    id: string;
  }): Observable<StrictHttpResponse<void>> {

    const rb = new RequestBuilder(this.rootUrl, FarmerControllerService.FarmerControllerDeleteByIdPath, 'delete');
    if (params) {
      rb.path('id', params.id, {});
    }

    return this.http.request(rb.build({
      responseType: 'text',
      accept: '*/*'
    })).pipe(
      filter((r: any) => r instanceof HttpResponse),
      map((r: HttpResponse<any>) => {
        return (r as HttpResponse<any>).clone({ body: undefined }) as StrictHttpResponse<void>;
      })
    );
  }

  /**
   * This method provides access to only to the response body.
   * To access the full response (for headers, for example), `deleteById$Response()` instead.
   *
   * This method doesn't expect any request body.
   */
  deleteById(params: {
    id: string;
  }): Observable<void> {

    return this.deleteById$Response(params).pipe(
      map((r: StrictHttpResponse<void>) => r.body as void)
    );
  }

  /**
   * Path part for operation farmerControllerUpdateById
   */
  static readonly FarmerControllerUpdateByIdPath = '/farmers/{id}';

  /**
   * This method provides access to the full `HttpResponse`, allowing access to response headers.
   * To access only the response body, use `updateById()` instead.
   *
   * This method sends `application/json` and handles request body of type `application/json`.
   */
  updateById$Response(params: {
    id: string;
    body?: FarmerPartial
  }): Observable<StrictHttpResponse<void>> {

    const rb = new RequestBuilder(this.rootUrl, FarmerControllerService.FarmerControllerUpdateByIdPath, 'patch');
    if (params) {
      rb.path('id', params.id, {});
      rb.body(params.body, 'application/json');
    }

    return this.http.request(rb.build({
      responseType: 'text',
      accept: '*/*'
    })).pipe(
      filter((r: any) => r instanceof HttpResponse),
      map((r: HttpResponse<any>) => {
        return (r as HttpResponse<any>).clone({ body: undefined }) as StrictHttpResponse<void>;
      })
    );
  }

  /**
   * This method provides access to only to the response body.
   * To access the full response (for headers, for example), `updateById$Response()` instead.
   *
   * This method sends `application/json` and handles request body of type `application/json`.
   */
  updateById(params: {
    id: string;
    body?: FarmerPartial
  }): Observable<void> {

    return this.updateById$Response(params).pipe(
      map((r: StrictHttpResponse<void>) => r.body as void)
    );
  }

  /**
   * Path part for operation farmerControllerFind
   */
  static readonly FarmerControllerFindPath = '/farmers';

  /**
   * This method provides access to the full `HttpResponse`, allowing access to response headers.
   * To access only the response body, use `find()` instead.
   *
   * This method doesn't expect any request body.
   */
  find$Response(params?: {
    filter?: { 'where'?: { [key: string]: any }, 'fields'?: { 'prefix'?: boolean, 'id'?: boolean, 'firstName'?: boolean, 'middleName'?: boolean, 'lastName'?: boolean, 'suffix'?: boolean, 'mobile'?: boolean, 'gender'?: boolean, 'civil'?: boolean, 'birthdate'?: boolean, 'religion'?: boolean, 'mother'?: boolean, 'isHousehold'?: boolean, 'isPwd'?: boolean, 'isBen'?: boolean, 'isInd'?: boolean, 'address'?: boolean, 'address2'?: boolean, 'barangay'?: boolean, 'province'?: boolean, 'city'?: boolean, 'postalCode'?: boolean, 'education'?: boolean, 'livelihood'?: boolean, 'isAqua'?: boolean, 'isCrop'?: boolean, 'isDairy'?: boolean, 'isFruit'?: boolean, 'isMeat'?: boolean, 'isPoultry'?: boolean, 'farmType'?: boolean, 'farmLot'?: boolean, 'farmName'?: boolean, 'farmSince'?: boolean, 'farmArea'?: boolean, 'isIrrigated'?: boolean, 'isOrgMember'?: boolean, 'orgName'?: boolean, 'isConventional'?: boolean, 'isSustainable'?: boolean, 'isNatural'?: boolean, 'isIntegrated'?: boolean, 'isMonoculture'?: boolean, 'isOrganic'?: boolean, [key: string]: any }, 'offset'?: number, 'limit'?: number, 'skip'?: number, 'order'?: Array<string> };
  }): Observable<StrictHttpResponse<Array<FarmerWithRelations>>> {

    const rb = new RequestBuilder(this.rootUrl, FarmerControllerService.FarmerControllerFindPath, 'get');
    if (params) {
      rb.query('filter', params.filter, {"style":"deepObject","explode":true});
    }

    return this.http.request(rb.build({
      responseType: 'json',
      accept: 'application/json'
    })).pipe(
      filter((r: any) => r instanceof HttpResponse),
      map((r: HttpResponse<any>) => {
        return r as StrictHttpResponse<Array<FarmerWithRelations>>;
      })
    );
  }

  /**
   * This method provides access to only to the response body.
   * To access the full response (for headers, for example), `find$Response()` instead.
   *
   * This method doesn't expect any request body.
   */
  find(params?: {
    filter?: { 'where'?: { [key: string]: any }, 'fields'?: { 'prefix'?: boolean, 'id'?: boolean, 'firstName'?: boolean, 'middleName'?: boolean, 'lastName'?: boolean, 'suffix'?: boolean, 'mobile'?: boolean, 'gender'?: boolean, 'civil'?: boolean, 'birthdate'?: boolean, 'religion'?: boolean, 'mother'?: boolean, 'isHousehold'?: boolean, 'isPwd'?: boolean, 'isBen'?: boolean, 'isInd'?: boolean, 'address'?: boolean, 'address2'?: boolean, 'barangay'?: boolean, 'province'?: boolean, 'city'?: boolean, 'postalCode'?: boolean, 'education'?: boolean, 'livelihood'?: boolean, 'isAqua'?: boolean, 'isCrop'?: boolean, 'isDairy'?: boolean, 'isFruit'?: boolean, 'isMeat'?: boolean, 'isPoultry'?: boolean, 'farmType'?: boolean, 'farmLot'?: boolean, 'farmName'?: boolean, 'farmSince'?: boolean, 'farmArea'?: boolean, 'isIrrigated'?: boolean, 'isOrgMember'?: boolean, 'orgName'?: boolean, 'isConventional'?: boolean, 'isSustainable'?: boolean, 'isNatural'?: boolean, 'isIntegrated'?: boolean, 'isMonoculture'?: boolean, 'isOrganic'?: boolean, [key: string]: any }, 'offset'?: number, 'limit'?: number, 'skip'?: number, 'order'?: Array<string> };
  }): Observable<Array<FarmerWithRelations>> {

    return this.find$Response(params).pipe(
      map((r: StrictHttpResponse<Array<FarmerWithRelations>>) => r.body as Array<FarmerWithRelations>)
    );
  }

  /**
   * Path part for operation farmerControllerCreate
   */
  static readonly FarmerControllerCreatePath = '/farmers';

  /**
   * This method provides access to the full `HttpResponse`, allowing access to response headers.
   * To access only the response body, use `create()` instead.
   *
   * This method sends `application/json` and handles request body of type `application/json`.
   */
  create$Response(params?: {
    body?: NewFarmer
  }): Observable<StrictHttpResponse<Farmer>> {

    const rb = new RequestBuilder(this.rootUrl, FarmerControllerService.FarmerControllerCreatePath, 'post');
    if (params) {
      rb.body(params.body, 'application/json');
    }

    return this.http.request(rb.build({
      responseType: 'json',
      accept: 'application/json'
    })).pipe(
      filter((r: any) => r instanceof HttpResponse),
      map((r: HttpResponse<any>) => {
        return r as StrictHttpResponse<Farmer>;
      })
    );
  }

  /**
   * This method provides access to only to the response body.
   * To access the full response (for headers, for example), `create$Response()` instead.
   *
   * This method sends `application/json` and handles request body of type `application/json`.
   */
  create(params?: {
    body?: NewFarmer
  }): Observable<Farmer> {

    return this.create$Response(params).pipe(
      map((r: StrictHttpResponse<Farmer>) => r.body as Farmer)
    );
  }

  /**
   * Path part for operation farmerControllerUpdateAll
   */
  static readonly FarmerControllerUpdateAllPath = '/farmers';

  /**
   * This method provides access to the full `HttpResponse`, allowing access to response headers.
   * To access only the response body, use `updateAll()` instead.
   *
   * This method sends `application/json` and handles request body of type `application/json`.
   */
  updateAll$Response(params?: {
    body?: FarmerPartial
  }): Observable<StrictHttpResponse<{ 'count'?: number }>> {

    const rb = new RequestBuilder(this.rootUrl, FarmerControllerService.FarmerControllerUpdateAllPath, 'patch');
    if (params) {
      rb.body(params.body, 'application/json');
    }

    return this.http.request(rb.build({
      responseType: 'json',
      accept: 'application/json'
    })).pipe(
      filter((r: any) => r instanceof HttpResponse),
      map((r: HttpResponse<any>) => {
        return r as StrictHttpResponse<{ 'count'?: number }>;
      })
    );
  }

  /**
   * This method provides access to only to the response body.
   * To access the full response (for headers, for example), `updateAll$Response()` instead.
   *
   * This method sends `application/json` and handles request body of type `application/json`.
   */
  updateAll(params?: {
    body?: FarmerPartial
  }): Observable<{ 'count'?: number }> {

    return this.updateAll$Response(params).pipe(
      map((r: StrictHttpResponse<{ 'count'?: number }>) => r.body as { 'count'?: number })
    );
  }

}
