import React, { Component } from 'react';
import ReactTable from "react-table";
import matchSorter from 'match-sorter'
import Modal from 'react-responsive-modal';
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';


export default class DepartmentModal extends Component {
    constructor() {
        super();
        this.state = {
            institutions: [],
            originalDept: [],
            department: []
            
        }
        this.handleSubmit = this.handleSubmit.bind(this);
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
        axios.get('api/department') //populate  dept
            .then(response => {
                let department = response.data;
                this.setState({ department: department });     
            })
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
        const institutions = this.state.institutions;
        const originalDept = this.state.originalDept;
        const department = this.state.department;
        const institutionItems = institutions.map((institution) =>
            <option key={institution.institutionID} value={institution.institutionID}>{institution.institutionName}</option> 
        );
        const departmentItems = department.map((department) =>
            <option key={department.deptID} value={department.deptID}>{department.deptName}</option> 
        );
          
        return (
            <div>
                <h1 style={{textAlign: "center"}}>Update Department Info</h1>
                <p><strong>Selected Department:</strong> {originalDept.deptName}</p>
                <p><strong>From Campus:</strong> {originalDept.institutionName}</p>
                <br/>      
                <form onSubmit={this.handleSubmit}>
                    <div className="twelve columns">
                        <label htmlFor="institution">Update Campus</label>
                        <select className="u-full-width" name="institution" id="institution">
                            {institutionItems}
                        </select>
                    </div>
                    <div className="twelve columns">
                        <label htmlFor="deptName">Update Department Name</label>
                        <input className="u-full-width" type="text" name="deptName" id="deptName" placeholder={department.deptName} />
                    </div>
                    <div className="twelve columns">
                        <label htmlFor="motherDept">Select Mother Department (if applicable)</label>
                        <select className="u-full-width" name="motherDept" id="motherDept">
                            {departmentItems}
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
