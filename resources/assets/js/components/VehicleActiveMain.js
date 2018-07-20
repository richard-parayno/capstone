import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import VehicleActive from './VehicleActive';

export default class VehicleActiveMain extends Component {
    constructor() {
        super();
        this.state = {
            vehicle: [],
        };
    }

    getActiveVehicles() {
        axios.get('api/vehicle/active')
            .then(vehicle => {
                vehicle=vehicle.data;
                this.setState({ vehicle });
            })
    }

    componentDidMount(){
        this.getActiveVehicles();
    }

    render() {
        return (
            <div>
                <h1>Active Vehicles</h1>
                <VehicleActive vehicle={this.state.vehicle}/>
            </div>   
        );
    }
}

if (document.getElementById('vehicle-active-table')) {
    ReactDOM.render(<VehicleActiveMain />, document.getElementById('vehicle-active-table'));
}
