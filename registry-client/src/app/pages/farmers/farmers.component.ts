import { AfterViewInit, Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { MatTable } from '@angular/material/table';
import { FarmersDataSource } from './farmers-datasource';
import { Farmer,FarmerWithRelations } from 'src/app/api/models';
import { FarmerControllerService } from 'src/app/api/services/farmer-controller.service';

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

  /** Columns displayed in the table. Columns IDs can be added, removed, or reordered. */
  displayedColumns = ['lastName', 'firstName','gender','mobile','city'];

  constructor(private farmerService: FarmerControllerService) {
    this.dataSource = new FarmersDataSource(this.farmerService);

  }

  ngOnInit() {

    this.dataSource.loadData();
    

  }

  ngAfterViewInit() {
    this.dataSource.sort = this.sort;
    this.dataSource.paginator = this.paginator;
    this.table.dataSource = this.dataSource;
  }
}
