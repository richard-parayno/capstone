import React, { Component } from 'react';
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';


export default class UserModal extends Component {
    constructor() {
        super();
        this.state = {
            user: []
        }
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    populateForm() {
        axios.get('api/users/' + this.props.originalUser) //populate user
            .then(response => {
                let user = response.data;
                this.setState({ user: user });     
            })
        
    }

    handleSubmit(event) {
        event.preventDefault();
        const data = new FormData(event.target);
        data.append("originalUser", this.props.originalUser);

        axios.post('api/users/update/' + this.props.originalUser, data)
            .then((response) => {
                let updated = response.data;
                toast.success("🎉 User Updated!", {
                    position: toast.POSITION.TOP_RIGHT
                })
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
        const userInfo = this.props.userInfo;
        const userCreds = this.props.userCreds;

        const originalUser = this.state.user;

        if (userInfo) {
            return (
                <div>
                    <h1 style={{textAlign: "center"}}>Update User Info</h1>
                    <p><strong>Selected User:</strong> {originalUser.accountName}</p>
                    <p><strong>User Type:</strong> {originalUser.userTypeName}</p>
                    
                    <br/>

                    <form onSubmit={this.handleSubmit}>
                        <div className="six columns">
                            <label htmlFor="first-name">Update First Name</label>
                            <input className="u-full-width" type="text" name="first-name" id="first-name" placeholder="Richard Lance" />
                        </div>
                        <div className="six columns">
                            <label htmlFor="last-name">Update Last Name</label>
                            <input className="u-full-width" type="text" name="last-name" id="last-name" placeholder="Parayno" />
                        </div>
                        
                        <input type="submit" className="button-primary u-pull-right" />
                    </form>
                    <ToastContainer autoClose={1000} />                
                </div>
            );
        } else if (userCreds) {
            return (
                <div>
                    <h1 style={{textAlign: "center"}}>Update User Credentials</h1>
                    <p><strong>Selected User:</strong> {originalUser.accountName}</p>
                    <p><strong>User Type:</strong> {originalUser.userTypeName}</p>
                    <p><strong>User Name:</strong> {originalUser.username}</p>
                    <p><strong>Email:</strong> {originalUser.email}</p>
                    
                    <br/>
    
                    <form onSubmit={this.handleSubmit}>
                        <div className="twelve columns">
                            <label htmlFor="username">Update Userame</label>
                            <input className="u-full-width" type="text" name="username" id="username" placeholder="richard.lance" />
                        </div>
                        <div className="twelve columns">
                            <label htmlFor="email">Update E-mail</label>
                            <input className="u-full-width" type="email" name="email" id="email" placeholder="richard_parayno@dlsu.edu.ph" />
                        </div>
                        <div className="twelve columns">
                            <label htmlFor="password">Update Password</label>
                            <input className="u-full-width" type="password" name="password" id="password"/>
                        </div>
                        <input type="submit" className="button-primary u-pull-right" />
                    </form>
                    <ToastContainer autoClose={1000} />                
                </div>
            );
        }
        
    }
}
