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
            rowValue: [],
            update: false,
            delete: false
        }
        this.onOpenModal = this.onOpenModal.bind(this);
        this.onCloseModal = this.onCloseModal.bind(this);
    }

    onOpenModal(row, param) {   
        
        if (param === "update") {
            this.setState({ 
                open: true,
                rowValue: row,
                update: true,
                delete: false
            });
        }
        if (param === "delete") {
            this.setState({ 
                open: true,
                rowValue: row,
                update: false,
                delete: true
            });
        }
    };
    
    onCloseModal() {
        this.setState({
           open: false 
        });
    };


    render() {
        const department = this.props.department;

        const columns = [{
            Header: 'Name',
            id: 'deptName',
            accessor: 'deptName', // String-based value accessors!
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['deptName'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          }, {
            Header: 'Campus',
            id: 'institutionName',
            accessor: 'institutionName',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['institutionName'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          }, {
            Header: 'From',
            id: 'motherDeptName',
            accessor: 'motherDeptName',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['motherDeptName'] }),
            filterAll: true,
            style: {'whiteSpace': 'unset'}
          }, {
            Header: 'Actions', // Custom header components!
            accessor: 'deptID',
            Cell: row => (
                <div style={{textAlign: "center"}}>
                    <a onClick={() => this.onOpenModal(row.value, "update")} href="#update">Update</a>
                    <br/>
                </div> 

            ),
            filterable: false
          }]; 
          
        
    
        return (
            <div >
                <ReactTable
                    filterable
                    defaultFilterMethod={(filter, row) =>
                        String(row[filter.id]) === filter.value}
                    data={department}
                    columns={columns}
                    className="-striped -highlight"
                    />

                <Modal open={this.state.open} onClose={this.onCloseModal} center>
                    <DepartmentModal originalDept={this.state.rowValue} update={this.state.update} delete={this.state.delete} open={this.state.open} />
                </Modal>
            </div>
        );
    }
}
