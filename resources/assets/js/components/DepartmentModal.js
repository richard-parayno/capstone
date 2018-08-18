import React, { Component } from 'react';
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';


export default class DepartmentModal extends Component {
    constructor() {
        super();
        this.state = {
            institutions: [],
            originalDept: [],
            specificDept: [],
            department: [],
            errorMessages: []   
        }
        this.handleSubmit = this.handleSubmit.bind(this);
        this.checkInputs = this.checkInputs.bind(this);
        this.handleDelete = this.handleDelete.bind(this);
        this.handleClose = this.handleClose.bind(this);
    }

    populateForm() {

        axios.get('api/institution') //populate institutions
            .then(response => {
                let institutions = response.data;
                this.setState({ institutions: institutions });
            })
        axios.get('api/department/' + this.props.originalDept) //populate  original dept
            .then(response => {
                let originalDept = response.data;
                this.setState({ originalDept: originalDept });     
            })
        axios.get('api/department/specific/' + this.props.originalDept) //populate  original dept
            .then(response => {
                let specificDept = response.data;
                this.setState({ specificDept: specificDept });     
            })
        axios.get('api/department') //populate  dept
            .then(response => {
                let department = response.data;
                this.setState({ department: department });     
            })
    }

    dismissAll(){
        toast.dismiss();
    }
        

    handleSubmit(event) {
        event.preventDefault();
        const data = new FormData(event.target);
        data.append("originalDept", this.props.originalDept);

        axios.post('api/department/update/' + this.props.originalDept, data)
            .then((response) => {
                let updated = response.data;
                toast.success("🎉 Department Info Updated!", {
                    position: toast.POSITION.TOP_RIGHT
                })
                console.log(response);
                if (response.status == 200) {
                    setTimeout(function() {
                        window.location.reload()
                    }, 1500);
                }
                
            })
            .catch((error) => {
                // Error
                if (error.response.status == 422) {
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    // console.log(error.response.status);
                    // console.log(error.response.headers);
                    this.setState({ errorMessages: error.response.data.errors });
                    if (this.state.errorMessages.deptName) {
                        toast.error(this.state.errorMessages.deptName[0], {
                            position: toast.POSITION.TOP_RIGHT,
                            autoClose: false
                        })
                    }
                    if (this.state.errorMessages.institutionID) {
                        toast.error(this.state.errorMessages.institutionID[0], {
                            position: toast.POSITION.TOP_RIGHT,
                            autoClose: false
                        })
                    }
                    if (this.state.errorMessages.motherDeptID) {
                        toast.error(this.state.errorMessages.motherDeptID[0], {
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
                
            });
        
    }

    handleDelete(event) {
        event.preventDefault();
        
        axios.delete('api/department/remove/' + this.props.originalDept)
    }

    handleClose(event) {
        event.preventDefault;
        var e = new Event("keydown");
        e.keyCode=27;
        e.which=e.keyCode;
        document.dispatchEvent(e);// just enter the char you want to send 
    }

    componentDidMount() {
        this.populateForm();
        
    }

    checkInputs() {
        let dept = document.getElementById("deptName");
        if (dept.value.length > 0) {
            dept.removeAttribute("style");
        } else {
            dept.style.border = "1px solid red";
        }
    }


   
    render() {
        const update = this.props.update;
        const deleteProp = this.props.delete;

        const institutions = this.state.institutions;
        const originalDept = this.state.originalDept;
        const department = this.state.department;
        const specificDept = this.state.specificDept;

        const institutionItems = institutions.map((institution) =>
            <option key={institution.institutionID} value={parseInt(institution.institutionID)}>{institution.institutionName}</option> 
        );
        const departmentItems = department.map((department) =>
            <option key={department.deptID} value={parseInt(department.deptID)}>{department.deptName}</option> 
        );

        const specificDeptItems = specificDept.map((specificDept) =>
            <option key={specificDept.deptID} value={parseInt(specificDept.deptID)}>{specificDept.deptName}</option>
        );

        
        if (update) {
            return (
                <div>
                    <h1 style={{textAlign: "center"}}>Update Department Info</h1>
                    <p><strong>Selected Department Details:</strong></p>
                    <table style={{marginLeft: 'auto', marginRight: 'auto'}}>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Campus</th>
                                <th>Under</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{originalDept.deptName}</td>    
                                <td>{originalDept.institutionName}</td>    
                                <td>{originalDept.motherDeptName}</td>    
                            </tr>    
                        </tbody>
                    </table>
                    <br/>     
                    <form onSubmit={this.handleSubmit}>
                        <div className="twelve columns">
                            <label htmlFor="deptName">Update Department Name</label>
                            {this.state.errorMessages.deptName ?
                                <input className="u-full-width" type="text" name="deptName" id="deptName" defaultValue={originalDept.deptName} style={{border: "1px red solid" }} /> 
                                :
                                <input className="u-full-width" type="text" name="deptName" id="deptName" defaultValue={originalDept.deptName}/>
                            }
                            
                        </div>
                        <div className="twelve columns">
                            <label htmlFor="motherDept">Select Mother Department (if applicable)</label>
                            {this.state.errorMessages.motherDeptID ? 
                                <select className="u-full-width" name="motherDept" id="motherDept" style={{border: "1px red solid"}}  value={originalDept.motherDeptID != null ? originalDept.motherDeptID : 0}>
                                    <option value="">N/A</option>    
                                    {specificDeptItems}
                                </select>   
                                :
                                <select className="u-full-width" name="motherDept" id="motherDept" value={originalDept.motherDeptID != null ? originalDept.motherDeptID : 0}>
                                    <option value="">N/A</option>    
                                    {specificDeptItems}
                                </select>
                            }        
                        </div>
                        <br/>
                        <input type="submit" className="button-primary u-pull-right" onClick={this.dismissAll}/>
                    </form>
                   
                    
                    <ToastContainer autoClose={1000} />                
                </div>
            );
        } else if (deleteProp) {
            return (
                <div>
                    <h1 style={{textAlign: "center"}}>Remove Department</h1>
                    <p><strong>Selected Department:</strong> {originalDept.deptName}</p>
                    <p><strong>From Campus:</strong> {originalDept.institutionName}</p>
                    <p><strong>Mother Department:</strong> {originalDept.motherDeptName}</p>
                    <br/>      
                    <form onSubmit={this.handleDelete}>
                        <p><strong>Are you sure you want to remove this department? There will be no undoing this action.</strong></p>
                        <br/>
                        <div className="twelve columns">
                        <input type="submit" value="Yes" className="button-primary u-pull-right" onClick={this.dismissAll}/>
                        
                        <a className="button button-primary" onClick={this.handleClose}>No</a>
                        </div>
                    </form>
                    <ToastContainer autoClose={1000} />                
                </div>
            );
        }
        
        
        
    }
}
