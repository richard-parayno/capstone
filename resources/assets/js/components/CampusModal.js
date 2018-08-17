import React, { Component } from 'react';
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';


export default class CampusModal extends Component {
    constructor() {
        super();
        this.state = {
            schoolTypes: [],
            originalInstitution: [],
            errorMessages: []
            
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
                if (error.response.status == 422) {
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    // console.log(error.response.status);
                    // console.log(error.response.headers);
                    this.setState({ errorMessages: error.response.data.errors });
                    if (this.state.errorMessages.institutionName) {
                        toast.error(this.state.errorMessages.institutionName[0], {
                            position: toast.POSITION.TOP_RIGHT,
                            autoClose: false
                        })
                    }
                    if (this.state.errorMessages.location) {
                        toast.error(this.state.errorMessages.location[0], {
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

    dismissAll(){
        toast.dismiss();
        let campus = document.getElementById("institutionName");
        let location = document.getElementById("location");
        campus.removeAttribute("style");
        location.removeAttribute("style");
    }

    checkInputs() {
        let campus = document.getElementById("institutionName");
        if (campus.value.length > 0) {
            campus.removeAttribute("style");
        } else {
            campus.style.border = "1px solid red";
        }

        let location = document.getElementById("location");
        if (location.value.length > 0) {
            location.removeAttribute("style");
        } else {
            location.style.border = "1px solid red";
        }
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
                <p><strong>Selected Campus Details:</strong></p>
                <table style={{marginLeft: 'auto', marginRight: 'auto'}}>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Classification</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{originalInstitution.institutionName}</td>    
                            <td>{originalInstitution.location}</td>    
                            <td>{originalInstitution.schoolTypeName}</td>    
                        </tr>    
                    </tbody>
                </table>
                <br/>  
                <form onSubmit={this.handleSubmit}>
                    <div className="twelve columns">
                        <label htmlFor="institutionName">Update Campus Name</label>
                        {typeof this.state.errorMessages.institutionName != undefined ?
                            <input className="u-full-width" type="text" name="institutionName" id="institutionName" defaultValue={originalInstitution.institutionName} />
                            :
                            <input className="u-full-width" type="text" name="institutionName" id="institutionName" defaultValue={originalInstitution.institutionName} style={{border: "1px red solid" }} onInput={this.checkInputs}/>
                        }
                    </div>
                    <div className="twelve columns">
                        <label htmlFor="location">Update Location</label>
                        {typeof this.state.errorMessages.location != undefined ?
                            <input className="u-full-width" type="text" name="location" id="location" defaultValue={originalInstitution.location} />
                            :
                            <input className="u-full-width" type="text" name="location" id="location" defaultValue={originalInstitution.location} style={{border: "1px red solid"}} onInput={this.checkInputs}/>
                        }
                    </div>
                    <div className="twelve columns">
                        <label htmlFor="schoolTypeID">Update Classification</label>
                        <select className="u-full-width" name="schoolTypeID" id="schoolTypeID" value={originalInstitution.schoolTypeID}>
                            {schoolTypesItems}
                        </select>
                    </div>
                    <br/>
                    <input type="submit" className="button-primary u-pull-right" onClick={this.dismissAll} />
                </form>
                <ToastContainer autoClose={1000} />                
            </div>
        );
        
        
        
    }
}
