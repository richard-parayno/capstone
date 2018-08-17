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
        this.markAsRead = this.markAsRead.bind(this);
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

    markAsRead(param) {
        axios.post('api/notifications/update', {notifID: param})
            .then(response => {
                console.log(response);
                this.getNotifications();
            })
    }


    componentDidMount() {
        this.getNotifications();
    }    

    render() {
        const notifications = this.state.notifs;

        let notificationsItems

        if (notifications.length > 0) {
            notificationsItems = notifications.slice(0, 5).map((notifications) =>{
                return <div key={notifications.notifID} style={{paddingTop: 10, borderBottom: 1, borderColor: 'black', borderBottomStyle: 'solid'}}>
                    <p><strong>{notifications.fromUser}</strong></p>
                    <p>{notifications.actionName}:</p>
                    <p>{notifications.remarks}</p>
                    <p>{notifications.readableDate}</p>
                    <a href="#" style={{textDecoration: 'none' }} onClick={() => this.markAsRead(notifications.notifID)}>Mark as Read</a>
                </div>
            });
        } else {
            notificationsItems = <p>You have no unread notifications!</p>;
        }


        return (
            <div className="u-pull-right">
                <a href="#" className="button-primary button" onClick={this.handleClick} ref={(node) => { this.target = node }} >Unread Notifications</a>
                
                <Popover placement='bottom' show={this.state.open} onHide={this.handleClose} target={this.target}>
                <div>
                    <div style={{borderBottom: 1, borderColor: 'black', borderBottomStyle: 'solid'}}>
                        <p><strong>Unread Notifications</strong></p>
                        <a href={window.notificationsView} style={{textDecoration: 'none'}}>View All Notifications</a>
                    </div>
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
