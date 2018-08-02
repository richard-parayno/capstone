import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import UploadedTrip from './UploadedTrip';
import { slide as Menu } from 'react-burger-menu';


export default class UploadedTripMain extends Component {
    constructor() {
        super();
        this.state = {
            trip: [],
        };
    }

    getTrips() {
        axios.get('api/trip')
            .then(trip => {
                trip=trip.data;
                this.setState({ trip });
            })
    }

    componentDidMount(){
        this.getTrips();
    }

    render() {
        return (
            <UploadedTrip trip={this.state.trip}/>
        );
    }
}

if (document.getElementById('uploaded-trip-table')) {
    ReactDOM.render(<UploadedTripMain />, document.getElementById('uploaded-trip-table'));
}
