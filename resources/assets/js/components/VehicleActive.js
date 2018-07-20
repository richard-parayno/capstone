import React, { Component } from 'react';
import ReactTable from "react-table";
import matchSorter from 'match-sorter'


export default class Vehicle extends Component {

    render() {
        const vehicle = this.props.vehicle;

        const onRowClick = (state, rowInfo, column, instance) => {
            return {
                onClick: e => {
                    console.log('A Td Element was clicked!')
                    console.log('it produced this event:', e)
                    console.log('It was in this column:', column)
                    console.log('It was in this row:', rowInfo)
                    console.log('It was in this table instance:', instance)
                    document.getElementById('plateNumber').value = rowInfo.row.plateNumber
                }
            }
        }

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
          }]; 
    
        return (
            <ReactTable
                filterable
                defaultFilterMethod={(filter, row) =>
                    String(row[filter.id]) === filter.value}
                data={vehicle}
                columns={columns}
                className="-striped -highlight"
                getTdProps={onRowClick}
                />
        );
    }
}
