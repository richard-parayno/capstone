import React, { Component } from 'react';
import ReactTable from "react-table";
import matchSorter from 'match-sorter'
import Modal from 'react-responsive-modal';
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';


export default class CampusModal extends Component {
    constructor() {
        super();
        this.state = {
            schoolTypes: [],
            originalInstitution: []
            
        }
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    populateForm() {

        axios.get('api/institution/schooltypes') //populate school types
            .then(response => {
                let schoolTypes = response.data;
                this.setState({ schoolTypes: schoolTypes });
            })
        axios.get('api/institution/' + this.props.originalInstitution) //populate  original dept
            .then(response => {
                let originalInstitution = response.data;
                this.setState({ originalInstitution: originalInstitution });     
            })
        
    }

    handleSubmit(event) {
        event.preventDefault();
        const data = new FormData(event.target);
        data.append("originalInstitution", this.props.originalInstitution);

        axios.post('api/institution/update/' + this.props.originalInstitution, data)
            .then((response) => {
                let updated = response.data;
                toast.success("🎉 Campus Info Updated!", {
                    position: toast.POSITION.TOP_RIGHT
                })
                console.log(updated);
                setTimeout(function() {
                    window.location.reload()
                }, 1500);
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

    componentDidMount() {
        this.populateForm();
    }

   
    render() {
        const schoolTypes = this.state.schoolTypes;
        const originalInstitution = this.state.originalInstitution;

        const schoolTypesItems = schoolTypes.map((schoolTypes) => 
            <option key={schoolTypes.schoolTypeID} value={schoolTypes.schoolTypeID}>{schoolTypes.schoolTypeName}</option>
        )
          
        return (
            <div>
                <h1 style={{textAlign: "center"}}>Update Campus Info</h1>
                <p><strong>Selected Campus:</strong> {originalInstitution.institutionName}</p>
                <p><strong>Campus Location:</strong> {originalInstitution.location}</p>
                <p><strong>Campus Classification:</strong> {originalInstitution.schoolTypeName}</p>
                <br/>      
                <form onSubmit={this.handleSubmit}>
                    <div className="twelve columns">
                        <label htmlFor="institutionName">Update Campus Name</label>
                        <input className="u-full-width" type="text" name="institutionName" id="institutionName" placeholder={originalInstitution.institutionName} />
                    </div>
                    <div className="twelve columns">
                        <label htmlFor="location">Update Location</label>
                        <input className="u-full-width" type="text" name="location" id="location" placeholder={originalInstitution.location} />
                    </div>
                    <div className="twelve columns">
                        <label htmlFor="schoolTypeID">Update Classification</label>
                        <select className="u-full-width" name="schoolTypeID" id="schoolTypeID">
                            {schoolTypesItems}
                        </select>
                    </div>
                    <br/>
                    <input type="submit" className="button-primary u-pull-right" />
                </form>
                <ToastContainer autoClose={1000} />                
            </div>
        );
        
        
        
    }
}
