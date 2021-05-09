import { AfterViewInit, Component, OnInit, ViewChild, ElementRef } from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { MatTable } from '@angular/material/table';
import { FarmersDataSource } from './farmers-datasource';
import { Farmer,FarmerWithRelations } from 'src/app/api/models';
import { FarmerControllerService } from 'src/app/api/services/farmer-controller.service';

import { debounceTime, distinctUntilChanged, startWith, tap, delay } from 'rxjs/operators';
import { merge, fromEvent } from 'rxjs';

@Component({
  selector: 'app-farmers',
  templateUrl: './farmers.component.html',
  styleUrls: ['./farmers.component.scss']
})
export class FarmersComponent implements AfterViewInit, OnInit {
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
  @ViewChild(MatTable) table: MatTable<FarmerWithRelations>;
  dataSource: FarmersDataSource;

  @ViewChild('input', { static: true }) input: ElementRef;


  /** Columns displayed in the table. Columns IDs can be added, removed, or reordered. */
  displayedColumns = ['lastName', 'firstName','gender','mobile','city'];

  constructor(private farmerService: FarmerControllerService) {
    

  }

  ngOnInit() {
    this.dataSource = new FarmersDataSource(this.farmerService);
    this.dataSource.loadData();
    

  }

  ngAfterViewInit() {
    // server-side search
    fromEvent(this.input.nativeElement,'keyup')
    .pipe(
        debounceTime(150),
        distinctUntilChanged(),
        tap(() => {
            this.paginator.pageIndex = 0;
            this.loadData();
        })
    )
    .subscribe();
    
    // reset the paginator after sorting
    this.sort.sortChange.subscribe(() => this.paginator.pageIndex = 0);
    
    merge(this.sort.sortChange, this.paginator.page)
        .pipe(
            tap(() => this.loadData())
        )
        .subscribe();


    this.dataSource.sort = this.sort;
    this.dataSource.paginator = this.paginator;
    this.table.dataSource = this.dataSource;
  }

  loadData() {
    const whereValue = this.input.nativeElement.value
    this.dataSource.loadData(whereValue)
  }
}
