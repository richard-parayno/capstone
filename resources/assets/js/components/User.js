import React, { Component } from 'react';
import ReactTable from "react-table";
import matchSorter from 'match-sorter'


export default class User extends Component {

    render() {
        const users = this.props.users;

        const columns = [{
            Header: 'User Type',
            id: 'userTypeName',
            accessor: 'userTypeName', // String-based value accessors!
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['userTypeName'] }),
            filterAll: true
          }, {
            Header: 'Account Name',
            id: 'accountName',
            accessor: 'accountName',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['accountName'] }),
            filterAll: true
          }, {
            Header: 'Username',
            id: 'username',
            accessor: 'username',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['username'] }),
            filterAll: true
          }, {
            Header: 'E-mail',
            id: 'email',
            accessor: 'email',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['email'] }),
            filterAll: true
          }, {
            Header: 'Account Status',
            id: 'status',
            accessor: 'status',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['status'] }),
            filterAll: true
          }, {
            Header: 'Actions', // Custom header components!
            accessor: 'id',
            Cell: row => (
                <div style={{textAlign: "center"}}>
                    <a href={"user-editinfo?user=" + row.value}>Update User Info</a> <br/>
                    <a href={"user-editcreds?user=" + row.value}>Update User Credentials</a>
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
                data={users}
                columns={columns}
                className="-striped -highlight"
                />
        );
    }
}
