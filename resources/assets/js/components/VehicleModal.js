import React, { Component } from 'react';
import ReactTable from "react-table";
import matchSorter from 'match-sorter'
import Modal from 'react-responsive-modal';
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';


export default class Vehicle extends Component {
    constructor() {
        super();
        this.state = {
            institutions: [],
            vehicles: [],
            vehicleType: [],
            fuelType: [],
            vehicleBrand: []
        }
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    populateForm() {
        const plateNumber = this.props.plateNumber;

        axios.get('api/institution') //populate institutions
            .then(response => {
                let institutions = response.data;
                this.setState({ institutions: institutions });
            })
        axios.get('api/vehicle/' + plateNumber) //populate vehicle with plate
            .then(response => {
                let vehicles = response.data;
                this.setState({ vehicles: vehicles });     
            })
        axios.get('api/vehicle/cartypes') //populate cartypes
            .then(response => {
                let vehicleType = response.data;
                this.setState({ vehicleType: vehicleType });          
            })
        axios.get('api/vehicle/fueltypes') //populate fueltypes
            .then(response => {
                let fuelType = response.data;
                this.setState({ fuelType: fuelType });        
            })
        axios.get('api/vehicle/carbrands') //populate carbrands
            .then(response => {
                let vehicleBrand = response.data;
                this.setState({ vehicleBrand: vehicleBrand });
            })
    }

    handleSubmit(event) {
        event.preventDefault();
        const data = new FormData(event.target);
        data.append("originalPlateNumber", this.props.plateNumber);

        axios.post('api/vehicle/update/' + this.props.plateNumber, data)
            .then((response) => {
                let updated = response.data;
                toast.success("🎉 Vehicle Info Updated!", {
                    position: toast.POSITION.TOP_RIGHT
                })
                console.log(updated);
            })
            .catch((error) => {
                // Error
                if (error.response) {
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    console.log(error.response.data);
                    // console.log(error.response.status);
                    // console.log(error.response.headers);
                } else if (error.request) {
                    // The request was made but no response was received
                    // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                    // http.ClientRequest in node.js
                    console.log(error.request);
                } else {
                    // Something happened in setting up the request that triggered an Error
                    console.log('Error', error.message);
                }
                console.log(error.config);
            });
        
    }

    handleDecommission(event) {
        event.preventDefault();
        const data = new FormData(event.target);
        data.append("originalPlateNumber", this.props.plateNumber);
    }

    componentDidMount() {
        this.populateForm();
    }

   
    render() {
        const decom = this.props.decom;
        const update = this.props.update;

        const institutions = this.state.institutions;
        const vehicles = this.state.vehicles;
        const vehicleType = this.state.vehicleType;
        const fuelType = this.state.fuelType;
        const vehicleBrand = this.state.vehicleBrand;

        const institutionItems = institutions.map((institution) =>
            <option key={institution.institutionID} value={institution.institutionID}>{institution.institutionName}</option> 
        );

        //console.log(institutionItems);
        const vehicleTypeItems = vehicleType.map((vehicleType) =>
            <option key={vehicleType.carTypeID} value={vehicleType.carTypeID}>{vehicleType.carTypeName}</option> 
        );
        const fuelTypeItems = fuelType.map((fuelType) => 
            <option key={fuelType.fuelTypeID} value={fuelType.fuelTypeID}>{fuelType.fuelTypeName}</option>
        );
        const vehicleBrandItems = vehicleBrand.map((vehicleBrand) => 
            <option key={vehicleBrand.carBrandID} value={vehicleBrand.carBrandID}>{vehicleBrand.carBrandName}</option>
        );
        
        if (decom) {
            return (
                <div>
                    <h1 style={{textAlign: "center"}}>Decommission Vehicle</h1>
                    <p><strong>Selected Vehicle's Plate Number:</strong> {vehicles.plateNumber}</p>
                    <p><strong>Car Model:</strong> {vehicles.modelName}</p>
                    <p><strong>Car Brand:</strong> {vehicles.carBrandName}</p>
                    <p><strong>Car Type:</strong> {vehicles.carTypeName}</p>
                    <p><strong>Campus:</strong> {vehicles.institutionName}</p>
                    <p><strong>Fuel Type:</strong> {vehicles.fuelTypeName}</p>
                    {vehicles.active === 1 && 
                        <p><strong>Status: {vehicles.status}</strong></p>
                    } 
                    {vehicles.active === 0 &&
                        <p><strong>Status: {vehicles.status}</strong></p>
                    }
                    <br/>

                    {vehicles.active === 1 && 
                        <p><strong>Are you sure you want to decommission this vehicle?</strong></p>
                    } 
                    {vehicles.active === 0 &&
                        <p><strong>Are you sure you want to make this vehicle active?</strong></p>
                    }
                    <form onSubmit={this.handleSubmit}>
                        <input type="radio" name="vehicleChoice" value="yes" />
                        <span className="label-body">Yes</span>
                        <br/>
                        <input type="radio" name="vehicleChoice" value="no" />
                        <span className="label-body">No</span>
                        <br/>
                        <input type="submit" className="button-primary u-pull-right"/>
                    </form>
                </div>
            );
        } else if (update) {
            return (
                <div>
                    <h1 style={{textAlign: "center"}}>Update Vehicle Info</h1>
                    <p><strong>Selected Vehicle's Plate Number:</strong> {vehicles.plateNumber}</p>
                    <p><strong>Car Model:</strong> {vehicles.modelName}</p>
                    <p><strong>Car Brand:</strong> {vehicles.carBrandName}</p>
                    <p><strong>Car Type:</strong> {vehicles.carTypeName}</p>
                    <p><strong>Campus:</strong> {vehicles.institutionName}</p>
                    <p><strong>Fuel Type:</strong> {vehicles.fuelTypeName}</p>
                    <br/>
    
                    <form onSubmit={this.handleSubmit}>
                        <div className="twelve columns">
                            <label htmlFor="vehicleCampus">Update Campus</label>
                            <select className="u-full-width" name="vehicleCampus" id="vehicleCampus">
                                {institutionItems}
                            </select>
                        </div>
                        <div className="twelve columns">
                            <label htmlFor="vehicleBrand">Update Vehicle Brand</label>
                            <select className="u-full-width" name="vehicleBrand" id="vehicleBrand">
                                {vehicleBrandItems}
                            </select>
                        </div>
                        <div className="twelve columns">
                            <label htmlFor="vehicleType">Update Vehicle Type</label>
                            <select className="u-full-width" name="vehicleType" id="vehicleType">
                                {vehicleTypeItems}
                            </select>
                        </div>
                        <div className="twelve columns">
                            <label htmlFor="vehicleFuel">Update Fuel Type</label>
                            <select className="u-full-width" name="vehicleFuel" id="vehicleFuel">
                                {fuelTypeItems}
                            </select>
                        </div>
                        <div className="twelve columns">
                            <label htmlFor="vehicleModel">Update Model Name</label>
                            <input className="u-full-width" type="text" name="vehicleModel" id="vehicleModel" placeholder="L300" />
                        </div>
                        <div className="twelve columns">
                            <label htmlFor="vehiclePlate">Update Plate Number</label>
                            <input className="u-full-width" type="text" name="vehiclePlate" id="vehiclePlate" placeholder={this.props.plateNumber} maxLength="6"/>
                        </div>
                        <input type="submit" className="button-primary u-pull-right"/>
                    </form>
                    <ToastContainer />                
                </div>
            );
        }
        
    }
}
