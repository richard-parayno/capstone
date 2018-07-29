import React, { Component } from 'react';
import ReactTable from "react-table";
import matchSorter from 'match-sorter'
import Modal from 'react-responsive-modal';
import VehicleModal from './VehicleModal';


export default class Vehicle extends Component {
    constructor() {
        super();
        this.state = {
            open: false,
            update: false,
            decommission: false,
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
                update: true,
                decommission: false
            });
        }
        if (param === "b") {
            this.setState({ 
                open: true,
                rowValue: row,
                update: false,
                decommission: true
            });
        }
        
    };
    
    onCloseModal() {
        this.setState({
           open: false 
        });
    };

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
                    <a onClick={() => this.onOpenModal(row.value, "a")} href="#update">Update Vehicle Info</a> <br/>
                    <a onClick={() => this.onOpenModal(row.value, "b")} href="#decommission">Update Vehicle Status</a>
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
                data={vehicle}
                columns={columns}
                className="-striped -highlight"
                />
           
                <Modal open={this.state.open} onClose={this.onCloseModal} center>
                    <VehicleModal plateNumber={this.state.rowValue} decom={this.state.decommission} update={this.state.update} open={this.state.open} />
                </Modal>
            </div>

        );
    }
}
