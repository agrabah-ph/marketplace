import { DataSource } from '@angular/cdk/collections';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { map, catchError,finalize } from 'rxjs/operators';
import { Observable, of as observableOf, merge, BehaviorSubject } from 'rxjs';
import { Farmer,FarmerWithRelations } from 'src/app/api/models';
import { FarmerControllerService } from 'src/app/api/services/farmer-controller.service';

/**
 * Data source for the Farmers view. This class should
 * encapsulate all logic for fetching and manipulating the displayed data
 * (including sorting, pagination, and filtering).
 */
export class FarmersDataSource extends DataSource<FarmerWithRelations> {
  private loadingSubject = new BehaviorSubject<boolean>(false);
  public loading$ = this.loadingSubject.asObservable();

  public farmerSubject = new BehaviorSubject<FarmerWithRelations[]>([]);
  paginator: MatPaginator;
  sort: MatSort;


  constructor(private farmerService: FarmerControllerService) {
    super();
  }

  public loadData(whereValue = '') {
    let active = 'lastName';
    let direction = 'asc';
    let pageIndex = 0;
    let pageSize = 12;
    if (this.sort) {
      active = this.sort.active;
      direction = this.sort.direction;
    }
    if (this.paginator) {
      pageIndex = this.paginator.pageIndex;
      pageSize = this.paginator.pageSize;
    }


    this.loadingSubject.next(true);
    
    const where = whereValue !== '' ? {[active]: { regexp: `/${whereValue}/`}  } : undefined;
    const order = [active + ' ' + direction.toUpperCase()];
    
    const filter: string =  JSON.stringify(
      { where, order,  offset: pageIndex * pageSize, limit: pageSize}
      );
    this.farmerService.find({ filter })
    .pipe(
      catchError(err => observableOf([])),
      finalize(() => this.loadingSubject.next(false) )
    )
    .subscribe(result => {
      this.farmerSubject.next(result);
    },
    err => {
      console.log(err)
    })
  }

  /**
   * Connect this data source to the table. The table will only update when
   * the returned stream emits new items.
   * @returns A stream of the items to be rendered.
   */
  connect(): Observable<FarmerWithRelations[]> {
    return this.farmerSubject.asObservable();
  }

  /**
   *  Called when the table is being destroyed. Use this function, to clean up
   * any open connections or free any held resources that were set up during connect.
   */
  disconnect() {
    this.farmerSubject.complete();
    this.loadingSubject.complete();
  }
}
