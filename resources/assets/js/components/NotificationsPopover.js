import React, { Component } from 'react';
import Popover from 'react-simple-popover';
import ReactDOM from 'react-dom';
import axios from 'axios';


export default class NotificationsPopover extends Component {
    constructor() {
        super();
        this.state = {
            open: false,
            notifs: []
        };
        this.handleClick = this.handleClick.bind(this);
        this.handleClose = this.handleClose.bind(this);
    }


    handleClick(event) {
        event.preventDefault();
        this.setState({
            open: !this.state.open
        });
    }

    handleClose(event) {
        event.preventDefault();
        this.setState({
            open: false
        });
    }

    getNotifications() {
        axios.post('api/notifications', {currentUser: window.currentUserID})
            .then(notifs => {
                notifs = notifs.data;
                console.log(notifs);
                this.setState({ notifs });
            })
    }


    componentDidMount() {
        this.getNotifications();
    }    

    render() {
        const notifications = this.state.notifs;

        const notificationsItems = notifications.map((notifications) =>{
            return <div key={notifications.notifID} style={{paddingTop: 10, borderBottom: 1, borderColor: 'black', borderBottomStyle: 'solid'}}>
                <p><strong>From: {notifications.fromUser}</strong></p>
                <p>Message: {notifications.actionName} - {notifications.remarks}</p>
            </div>
        });

        return (
            <div className="u-pull-right">
                <a href="#" className="button-primary button" onClick={this.handleClick} ref={(node) => { this.target = node }} >Notifications</a>
                
                <Popover placement='bottom' show={this.state.open} onHide={this.handleClose} target={this.target}>
                <div>
                <p style={{borderBottom: 1, borderColor: 'black', borderBottomStyle: 'solid'}}><strong>Notifications</strong></p>
                {notificationsItems}
                </div>
                </Popover>
            </div>
            

        );
    }
}

if (document.getElementById('notifications')) {
    ReactDOM.render(<NotificationsPopover />, document.getElementById('notifications'));
}
