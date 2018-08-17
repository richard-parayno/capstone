import React, { Component } from 'react';
import ReactTable from "react-table";
import matchSorter from 'match-sorter'


export default class UploadedTrip extends Component {

    render() {
        const trip = this.props.trip;

        const columns = [{
            Header: 'Date',
            id: 'tripDate',
            accessor: 'tripDate', // String-based value accessors!
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['tripDate'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          }, {
            Header: 'Departure Time',
            id: 'tripTime',
            accessor: 'tripTime',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['tripTime'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          }, {
            Header: 'Requester',
            id: 'departmentName',
            accessor: 'departmentName',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['departmentName'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          }, {
            Header: 'Plate Number',
            id: 'plateNumber',
            accessor: 'plateNumber',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['plateNumber'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          }, {
            Header: 'KM Reading',
            id: 'kilometerReading',
            accessor: 'kilometerReading',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['kilometerReading'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          }, {
            Header: 'Destinations',
            id: 'remarks',
            accessor: 'remarks',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['remarks'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          },{
            Header: 'Date Uploaded',
            id: 'uploadedAt',
            accessor: 'uploadedAt',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['uploadedAt'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          },]; 
          
        
    
        return (
            <ReactTable
                filterable
                defaultFilterMethod={(filter, row) =>
                    String(row[filter.id]) === filter.value}
                data={trip}
                columns={columns}
                className="-striped -highlight"
                defaultSorted={[
                    {
                        id: 'date',
                        desc: true
                    }
                ]}
                />
        );
    }
}
