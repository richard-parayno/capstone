import React, { Component } from 'react';
import ReactTable from "react-table";
import matchSorter from 'match-sorter'


export default class Department extends Component {

    render() {
        const department = this.props.department;

        const columns = [{
            Header: 'Department Name',
            id: 'deptName',
            accessor: 'deptName', // String-based value accessors!
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['deptName'] }),
            filterAll: true
          }, {
            Header: 'From Campus',
            id: 'institutionName',
            accessor: 'institutionName',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['institutionName'] }),
            filterAll: true
          }, {
            Header: 'From Department',
            id: 'deptName',
            accessor: 'deptName',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['deptName'] }),
            filterAll: true
          }, {
            Header: 'Actions', // Custom header components!
            accessor: 'deptID',
            Cell: row => (
                <div style={{textAlign: "center"}}>
                    <a href={"department-editinfo?department=" + row.value}>Update Department Info</a>
                </div>
            ),
            filterable: false
          }]; 
          
        
    
        return (
            <ReactTable
                filterable
                defaultFilterMethod={(filter, row) =>
                    String(row[filter.id]) === filter.value}
                data={department}
                columns={columns}
                className="-striped -highlight"
                />
        );
    }
}
