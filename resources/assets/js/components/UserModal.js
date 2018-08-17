import React, { Component } from 'react';
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';


export default class UserModal extends Component {
    constructor() {
        super();
        this.state = {
            user: [],
            errorMessages: []
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
                if (error.response.status == 422) {
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    // console.log(error.response.status);
                    // console.log(error.response.headers);
                    this.setState({ errorMessages: error.response.data.errors });
                    if (this.state.errorMessages.accountName) {
                        toast.error(this.state.errorMessages.accountName[0], {
                            position: toast.POSITION.TOP_RIGHT,
                            autoClose: false
                        })
                    }
                    if (this.state.errorMessages.username) {
                        toast.error(this.state.errorMessages.username[0], {
                            position: toast.POSITION.TOP_RIGHT,
                            autoClose: false
                        })
                    }
                    if (this.state.errorMessages.userTypeName) {
                        toast.error(this.state.errorMessages.userTypeName[0], {
                            position: toast.POSITION.TOP_RIGHT,
                            autoClose: false
                        })
                    }
                    if (this.state.errorMessages.email) {
                        toast.error(this.state.errorMessages.email[0], {
                            position: toast.POSITION.TOP_RIGHT,
                            autoClose: false
                        })
                    }
                    if (this.state.errorMessages.password) {
                        toast.error(this.state.errorMessages.password[0], {
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
    }
   
    render() {
        const userInfo = this.props.userInfo;
        const userCreds = this.props.userCreds;

        const originalUser = this.state.user;

        if (userCreds) {
            return (
                <div>
                    <h1 style={{textAlign: "center"}}>Update User Info</h1>
                    <p><strong>Selected User:</strong> {originalUser.accountName}</p>
                    <p><strong>User Type:</strong> {originalUser.userTypeName}</p>
                    
                    <br/>

                    <form onSubmit={this.handleSubmit}>
                        
                        
                        <input type="submit" className="button-primary u-pull-right" />
                    </form>
                    <ToastContainer autoClose={1000} />                
                </div>
            );
        } else if (userInfo) {
            return (
                <div>
                    <h1 style={{textAlign: "center"}}>Update User Credentials</h1>
                    <p><strong>Selected User's Details:</strong></p>
                    <br/>
                    <table style={{marginLeft: 'auto', marginRight: 'auto'}}>
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Account Name</th>
                                <th>Username</th>
                                <th>E-mail</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{originalUser.userTypeName}</td>    
                                <td>{originalUser.accountName}</td>    
                                <td>{originalUser.username}</td>    
                                <td>{originalUser.email}</td>    
                                <td>{originalUser.status}</td>    
                            </tr>    
                        </tbody>
                    </table>
                    
                    <br/>
    
                    <div className="twelve columns">
                    <form onSubmit={this.handleSubmit}>
                        <div className="six columns">
                            <label htmlFor="accountName">Update Account Name</label>
                            {typeof this.state.errorMessages.accountName != undefined ?
                                <input className="u-full-width" type="text" name="accountName" id="accountName" defaultValue="Richard Lance" />
                                :
                                <input className="u-full-width" type="text" name="accountName" id="accountName" defaultValue="Richard Lance" style={{border: "1px red solid"}}/>
                            }
                        </div>
                        <div className="six columns">
                            <label htmlFor="username">Update Userame</label>
                            {typeof this.state.errorMessages.username != undefined ?
                                <input className="u-full-width" type="text" name="username" id="username" defaultValue="richard.lance" />
                                :
                                <input className="u-full-width" type="text" name="username" id="username" defaultValue="richard.lance" style={{border: "1px red solid"}}/>
                            }
                        </div>
                        <div className="six columns" style={{marginLeft: 0}}>
                            <label htmlFor="email">Update E-mail</label>
                            {typeof this.state.errorMessages.email != undefined ?
                                <input className="u-full-width" type="email" name="email" id="email" defaultValue="richard_parayno@dlsu.edu.ph" />
                                :
                                <input className="u-full-width" type="email" name="email" id="email" defaultValue="richard_parayno@dlsu.edu.ph" style={{border: "1px red solid"}}/>
                            }
                        </div>
                        <div className="six columns">
                            <label htmlFor="password">Update Password</label>
                            {typeof this.state.errorMessages.password != undefined ?
                                <input className="u-full-width" type="password" name="password" id="password"/>
                                :
                                <input className="u-full-width" type="password" name="password" id="password" style={{border: "1px red solid"}}/>
                            }
                        </div>
                        <div className="twelve columns">
                            <input type="submit" className="button-primary u-pull-right" onClick={this.dismissAll} />
                        </div>
                    </form>
                    </div>
                    <ToastContainer autoClose={1000} />                
                </div>
            );
        }
        
    }
}
