import React, { Component } from 'react';
import ReactTable from "react-table";
import matchSorter from 'match-sorter'
import Modal from 'react-responsive-modal';
import UserModal from './UserModal';

export default class User extends Component {
    constructor() {
        super();
        this.state = {
            open: false,
            userInfo: false,
            userCreds: false,
            rowValue: []

        }
        this.onOpenModal = this.onOpenModal.bind(this);
        this.onCloseModal = this.onCloseModal.bind(this);
    }

    onOpenModal(row, param) {
        if (param === "a") {
            this.setState({ 
                open: true,
                rowValue: row,
                userInfo: true,
                userCreds: false
            });
        }
        if (param === "b") {
            this.setState({ 
                open: true,
                rowValue: row,
                userInfo: false,
                userCreds: true
            });
        }
        
    };

    onCloseModal() {
        this.setState({
           open: false 
        });
    };

    render() {
        const users = this.props.users;

        const columns = [{
            Header: 'Type',
            id: 'userTypeName',
            accessor: 'userTypeName', // String-based value accessors!
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['userTypeName'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          }, {
            Header: 'Account Name',
            id: 'accountName',
            accessor: 'accountName',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['accountName'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          }, {
            Header: 'Username',
            id: 'username',
            accessor: 'username',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['username'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          }, {
            Header: 'E-mail',
            id: 'email',
            accessor: 'email',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['email'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          }, {
            Header: 'Status',
            id: 'status',
            accessor: 'status',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['status'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          }, {
            Header: 'Actions', // Custom header components!
            accessor: 'id',
            Cell: row => (
                <div style={{textAlign: "center"}}>
                    <a onClick={() => this.onOpenModal(row.value, "a")} href="#updateinfo">Update</a>
                </div>
            ),
            filterable: false
          }]; 
          
        
    
        return (
            <div>
                <ReactTable
                    filterable
                    defaultFilterMethod={(filter, row) =>
                        String(row[filter.id]) === filter.value}
                    data={users}
                    columns={columns}
                    className="-striped -highlight"
                    />

                <Modal open={this.state.open} onClose={this.onCloseModal} center>
                    <UserModal originalUser={this.state.rowValue} userInfo={this.state.userInfo} userCreds={this.state.userCreds} open={this.state.open} />
                </Modal>
            </div>
            
        );
    }
}
