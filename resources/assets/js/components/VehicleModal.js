import React, { Component } from 'react';
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';


export default class VehicleModal extends Component {
    constructor() {
        super();
        this.state = {
            institutions: [],
            vehicles: [],
            vehicleType: [],
            fuelType: [],
            vehicleBrand: [],
            errorMessages: []
        }
        this.handleSubmit = this.handleSubmit.bind(this);
        this.dismissAll = this.dismissAll.bind(this);
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
                toast.success("🎉 Vehicle Updated!", {
                    position: toast.POSITION.TOP_RIGHT
                })
                console.log(updated);
                setTimeout(function() {
                    window.location.reload()
                }, 1500);
            })
            .catch((error) => {
                // Error
                if (error.response.status == 422) {
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    // console.log(error.response.status);
                    // console.log(error.response.headers);
                    this.setState({ errorMessages: error.response.data.errors });
                    if (this.state.errorMessages.modelName) {
                        toast.error(this.state.errorMessages.modelName[0], {
                            position: toast.POSITION.TOP_RIGHT,
                            autoClose: false
                        })
                    }
                    if (this.state.errorMessages.plateNumber) {
                        toast.error(this.state.errorMessages.plateNumber[0], {
                            position: toast.POSITION.TOP_RIGHT,
                            autoClose: false
                        })
                    }
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

    componentDidMount() {
        this.populateForm();
    }

    dismissAll() {
        toast.dismiss();
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
            
        } else if (update) {
            return (
                <div>
                    <h1 style={{textAlign: "center"}}>Update Vehicle Info</h1>
                    <p><strong>Selected Vehicle's Details:</strong></p>
                    <br/>
                    <table style={{marginLeft: 'auto', marginRight: 'auto'}}>
                        <thead>
                            <tr>
                                <th>Car Type</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Plate No.</th>
                                <th>Campus</th>
                                <th>Fuel Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{vehicles.carTypeName}</td>    
                                <td>{vehicles.carBrandName}</td>    
                                <td>{vehicles.modelName}</td>    
                                <td>{vehicles.plateNumber}</td>    
                                <td>{vehicles.institutionName}</td>    
                                <td>{vehicles.fuelTypeName}</td>    
                                <td>{vehicles.status}</td>
                            </tr>    
                        </tbody>
                    </table>
                    <br/>
    
                    <form onSubmit={this.handleSubmit}>
                        <div className="six columns">
                            <label htmlFor="carBrandID">Update Vehicle Brand</label>
                            <select className="u-full-width" name="carBrandID" id="carBrandID" defaultValue={vehicles.carBrandID}>
                                {vehicleBrandItems}
                            </select>
                        </div>
                        <div className="six columns">
                            <label htmlFor="carTypeID">Update Vehicle Type</label>
                            <select className="u-full-width" name="carTypeID" id="carTypeID" defaultValue={vehicles.carTypeID}>
                                {vehicleTypeItems}
                            </select>
                        </div>
                        <div className="six columns" style={{marginLeft: 0}}>
                            <label htmlFor="fuelTypeID">Update Fuel Type</label>
                            <select className="u-full-width" name="fuelTypeID" id="fuelTypeID" defaultValue={vehicles.fuelTypeID}>
                                {fuelTypeItems}
                            </select>
                        </div>
                        <div className="six columns">
                            <label htmlFor="modelName">Update Model Name</label>
                            {this.state.errorMessages.modelName ?
                                <input className="u-full-width" type="text" name="modelName" id="modelName" defaultValue={vehicles.modelName} style={{border: "1px red solid"}} />
                                :
                                <input className="u-full-width" type="text" name="modelName" id="modelName" defaultValue={vehicles.modelName} />
                            }
                        </div>
                        <div className="six columns" style={{marginLeft: 0}}>
                            <label htmlFor="plateNumber">Update Plate Number</label>
                            {this.state.errorMessages.plateNumber ?
                                <input className="u-full-width" type="text" name="plateNumber" id="plateNumber" defaultValue={vehicles.plateNumber} maxLength="6" style={{border: "1px red solid"}} />
                                :
                                <input className="u-full-width" type="text" name="plateNumber" id="plateNumber" defaultValue={vehicles.plateNumber} maxLength="6"/>
                            }
                        </div>
                        <div className="six columns">
                            <label htmlFor="vehicleChoice">Update Vehicle Status</label>
                            <select className="u-full-width" name="vehicleChoice" id="vehicleChoice" defaultValue={vehicles.active}>
                                <option value="1">Active</option>
                                <option value="0">Decommissioned</option>
                            </select>
                        </div>
                        <div className="twelve columns">
                            <input type="submit" className="button-primary u-pull-right" onClick={this.dismissAll}/>
                        </div>
                    </form>
                    <ToastContainer autoClose={1000} />                
                </div>
            );
        }
        
    }
}
