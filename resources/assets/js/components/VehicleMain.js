import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import Vehicle from './Vehicle';

export default class VehicleMain extends Component {
    constructor() {
        super();
        this.state = {
            vehicle: [],
        };
    }

    getVehicles() {
        axios.get('api/vehicle')
            .then(vehicle => {
                vehicle=vehicle.data;
                this.setState({ vehicle });
            })
    }

    componentDidMount(){
        this.getVehicles();
    }

    render() {
        return (
            <div>
                <h1>Manage Vehicles</h1>
                <Vehicle vehicle={this.state.vehicle}/>
            </div>   
        );
    }
}

if (document.getElementById('vehicle-table')) {
    ReactDOM.render(<VehicleMain />, document.getElementById('vehicle-table'));
}
