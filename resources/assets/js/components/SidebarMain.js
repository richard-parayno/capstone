import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { push as Menu } from 'react-burger-menu';


export default class SidebarMain extends Component {
    constructor() {
        super();
        this.state = {
            currentUser: [],
        }
    }

    getCurrentUser() {
        axios.get('api/users/' + window.currentUserID)
            .then(response => {
                this.setState({
                    currentUser: response.data
                })
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
        this.getCurrentUser();
    }
    

    render() {
        let homeItems = [];
        let accountItems = [];
        let campusItems = [];
        
        switch(this.state.currentUser.userTypeID) {
            
            case 1: //sysadmin
                homeItems = [
                    <p key="home"><strong>Home</strong></p>,
                    <li key="dashboard" id="home" className="menu-item" ><a href={window.dashboard} style={{color: 'white'}}>Dashboard</a></li>,
                    <li key="reports" id="about" className="menu-item" href="/about"><a href={window.reports} style={{color: 'white'}}>Reports</a></li>,
                    <li key="tripData" id="contact" className="menu-item" href="/contact"><a href={window.tripData} style={{color: 'white'}}>Trip Data</a></li>,
                    <li key="treePlant" className="menu-item--small" href=""><a href={window.wePlantedTrees} style={{color: 'white'}}>We Planted Trees</a></li>,
                    <li key="thresholdControl" className="menu-item--small" href=""><a href={window.thresholdControl} style={{color: 'white'}}>Threshold Settings</a></li>,
                ];
        
                accountItems = [
                    <p key="account"><strong>Account Management</strong></p>,
                    <li key="userManage" id="home" className="menu-item" ><a href={window.userManagement} style={{color: 'white'}}>  User Management</a></li>,
                ];
        
                campusItems = [
                    <p key="campus"><strong>Campus Information Management</strong></p>,
                    <li key="editCampus" id="home" className="menu-item" ><a href={window.campusManagement} style={{color: 'white'}}>Campus Management</a></li>,
                    <li key="departmentManage" id="home" className="menu-item" ><a href={window.departmentManagement} style={{color: 'white'}}>Department Management</a></li>,
                    <li key="vehicleManage" id="home" className="menu-item" ><a href={window.vehicleManagement} style={{color: 'white'}}>Vehicle Management</a></li>,
                ];

                break;

            case 2: //life
                homeItems = [
                    <p key="home"><strong>Home</strong></p>,
                    <li key="dashboard" id="home" className="menu-item" ><a href={window.dashboard} style={{color: 'white'}}>Dashboard</a></li>,
                    <li key="reports" id="about" className="menu-item" href="/about"><a href={window.reports} style={{color: 'white'}}>Reports</a></li>,
                    <li key="tripData" id="contact" className="menu-item" href="/contact"><a href={window.tripData} style={{color: 'white'}}>Trip Data</a></li>,
                    <li key="treePlant" className="menu-item--small" href=""><a href={window.wePlantedTrees} style={{color: 'white'}}>We Planted Trees</a></li>,
                    <li key="thresholdControl" className="menu-item--small" href=""><a href={window.thresholdControl} style={{color: 'white'}}>Threshold Settings</a></li>,
                ];
        
                accountItems = [];
        
                campusItems = [
                    <p key="campus"><strong>Campus Information Management</strong></p>,
                    <li key="editCampus" id="home" className="menu-item" ><a href={window.campusManagement} style={{color: 'white'}}>Campus Management</a></li>,
                    <li key="departmentManage" id="home" className="menu-item" ><a href={window.departmentManagement} style={{color: 'white'}}>Department Management</a></li>,
                    <li key="vehicleManage" id="home" className="menu-item" ><a href={window.vehicleManagement} style={{color: 'white'}}>Vehicle Management</a></li>,
                ];

                break;

            case 3: //champion
                homeItems = [
                    <p key="home"><strong>Home</strong></p>,
                    <li key="dashboard" id="home" className="menu-item" ><a href={window.dashboard} style={{color: 'white'}}>Dashboard</a></li>,
                    <li key="reports" id="about" className="menu-item" href="/about"><a href={window.reports} style={{color: 'white'}}>Reports</a></li>,
                    <li key="treePlant" className="menu-item--small" href=""><a href={window.wePlantedTrees} style={{color: 'white'}}>We Planted Trees</a></li>,
                ];
        
                accountItems = [];
        
                campusItems = [];

                break;

            case 4: //dispatch
                homeItems = [
                    <p key="home"><strong>Home</strong></p>,
                    <li key="dashboard" id="home" className="menu-item" ><a href={window.dashboard} style={{color: 'white'}}>Dashboard</a></li>,
                    <li key="tripData" id="contact" className="menu-item" href="/contact"><a href={window.tripData} style={{color: 'white'}}>Trip Data</a></li>,
                ];
        
                accountItems = [];
        
                campusItems = [
                    <p key="campus"><strong>Campus Information Management</strong></p>,
                    <li key="vehicleManage" id="home" className="menu-item" ><a href={window.vehicleManagement} style={{color: 'white'}}>Vehicle Management</a></li>,
                ];

                break;

            case 5: //sao
                homeItems = [
                    <p key="home"><strong>Home</strong></p>,
                    <li key="reports" id="about" className="menu-item" href="/about"><a href={window.reports} style={{color: 'white'}}>Reports</a></li>,
                ];
        
                accountItems = [];
        
                campusItems = [];


                break;
        }


        let styles = {
            bmBurgerButton: {
              position: 'fixed',
              width: '30px',
              height: '30px',
              left: '36px',
              top: '30px'
            },
            bmBurgerBars: {
              background: '#0b5023'
            },
            bmCrossButton: {
              height: '24px',
              width: '24px'
            },
            bmCross: {
              background: '#0b5023'
            },
            bmMenu: {
              background: '#0b5023',
              padding: '2.5em 1.5em 0',
              fontSize: '1.15em'
            },
            bmMorphShape: {
              fill: '#373a47'
            },
            bmItemList: {
              color: 'white',
              padding: '0.8em',
            },
            bmItem: {
              display: 'inline-block',
              cursor: 'pointer',
              color: 'inherit',
            },
           
          }

        return (

            <Menu styles={styles} pageWrapId={ "page-wrap" } outerContainerId={ "outer-container" }>
            <div className="twelve columns">
                <strong>Welcome, {this.state.currentUser.accountName}!</strong> <br/>
                <p style={{textTransform:"none"}}>{this.state.currentUser.userTypeName}</p> 
                <a href={window.logOut}>Log Out</a>
                <br/>
                <br/>

            </div>
            
            <div className="twelve columns">
                <ul>
                    {homeItems}
                </ul>
            </div>
            <div className="twelve columns">
                <ul>
                    {accountItems}
                </ul>
            </div>
            <div className="twelve columns">
                <ul>
                    {campusItems}
                </ul>
            </div>
                
                
            </Menu>  

        );
    }
}

if (document.getElementById('sidebar')) {
    ReactDOM.render(<SidebarMain />, document.getElementById('sidebar'));
}
