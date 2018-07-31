import React, { Component } from 'react';
import ReactTable from "react-table";
import matchSorter from 'match-sorter'
import Modal from 'react-responsive-modal';
import DepartmentModal from './DepartmentModal';

export default class Department extends Component {
    constructor() {
        super();
        this.state = {
            open: false,
            rowValue: []
        }
        this.onOpenModal = this.onOpenModal.bind(this);
        this.onCloseModal = this.onCloseModal.bind(this);
    }

    onOpenModal(row) {   
        this.setState({ 
            open: true,
            rowValue: row,
        });
    };
    
    onCloseModal() {
        this.setState({
           open: false 
        });
    };


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
                    <a onClick={() => this.onOpenModal(row.value)} href="#update">Update Department Info</a>
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
                    data={department}
                    columns={columns}
                    className="-striped -highlight"
                    />

                <Modal open={this.state.open} onClose={this.onCloseModal} center>
                    <DepartmentModal originalDept={this.state.rowValue} open={this.state.open} />
                </Modal>
            </div>
        );
    }
}
