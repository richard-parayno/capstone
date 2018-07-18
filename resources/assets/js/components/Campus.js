import React, { Component } from 'react';
import ReactTable from "react-table";
import matchSorter from 'match-sorter'


export default class Campus extends Component {

    render() {
        const institutions = this.props.institutions;

        const columns = [{
            Header: 'Campus/Institution',
            id: 'institutionName',
            accessor: 'institutionName', // String-based value accessors!
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['institutionName'] }),
            filterAll: true
          }, {
            Header: 'Type',
            id: 'schoolTypeName',
            accessor: 'schoolTypeName',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['schoolTypeName'] }),
            filterAll: true
          }, {
            Header: 'Location',
            id: 'location',
            accessor: 'location',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['location'] }),
            filterAll: true
          }, {
            Header: 'Actions', // Custom header components!
            accessor: 'institutionID',
            Cell: row => (
                <a href={"campus-editinfo?institution=" + row.value}>Update Campus</a>
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
                data={institutions}
                columns={columns}
                className="-striped -highlight"
                />
        );
    }
}
