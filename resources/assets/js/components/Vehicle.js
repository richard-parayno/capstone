import React, { Component } from 'react';
import ReactTable from "react-table";
import matchSorter from 'match-sorter'


export default class Vehicle extends Component {

    render() {
        const vehicle = this.props.vehicle;

        const columns = [{
            Header: 'Car Type',
            id: 'carTypeName',
            accessor: 'carTypeName', // String-based value accessors!
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['carTypeName'] }),
            filterAll: true
          }, {
            Header: 'Car Model',
            id: 'modelName',
            accessor: 'modelName',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['modelName'] }),
            filterAll: true
          }, {
            Header: 'Plate Number',
            id: 'plateNumber',
            accessor: 'plateNumber',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['plateNumber'] }),
            filterAll: true
          }, {
            Header: 'Home Campus',
            id: 'institutionName',
            accessor: 'institutionName',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['institutionName'] }),
            filterAll: true
          }, {
            Header: 'Fuel Type',
            id: 'fuelTypeName',
            accessor: 'fuelTypeName',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['fuelTypeName'] }),
            filterAll: true
          }, {
            Header: 'Status',
            id: 'status',
            accessor: 'status',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['status'] }),
            filterAll: true
          }, {
            Header: 'Actions', // Custom header components!
            accessor: 'plateNumber',
            Cell: row => (
                <div style={{textAlign: "center"}}>
                    <a href={"vehicle-editinfo?vehicle=" + row.value}>Update Vehicle Info</a> <br/>
                    <a href={"vehicle-decommission?user=" + row.value}>Decommission Vehicle</a>
                </div>
            ),
            filterable: false
          }]; 
          
        
    
        return (
            <ReactTable
                minRows='5'
                filterable
                defaultFilterMethod={(filter, row) =>
                    String(row[filter.id]) === filter.value}
                showPageSizeOptions={false}
                data={vehicle}
                columns={columns}
                className="-striped -highlight"
                />
        );
    }
}
