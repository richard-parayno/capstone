import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';


export default class NotificationsMain extends Component {
    constructor() {
        super();
        this.state = {
            readNotifs: [],
            unreadNotifs: []
        };
        this.markAsRead = this.markAsRead.bind(this);
    }


    getReadNotifications() {
        axios.post('api/notifications/all', {currentUser: window.currentUserID, read: 1})
            .then(readNotifs => {
                readNotifs = readNotifs.data;
                this.setState({ readNotifs });
            })
    }
    getUnreadNotifications() {
        axios.post('api/notifications/all', {currentUser: window.currentUserID, read: 0})
            .then(unreadNotifs => {
                unreadNotifs = unreadNotifs.data;
                this.setState({ unreadNotifs });
            })
    }

    markAsRead(param) {
        axios.post('api/notifications/update', {notifID: param})
            .then(response => {
                console.log(response);
                this.getReadNotifications();
                this.getUnreadNotifications();
            })
    }
    


    componentDidMount() {
        this.getReadNotifications();
        this.getUnreadNotifications();
    }    

    render() {
        const readNotifs = this.state.readNotifs;
        const unreadNotifs = this.state.unreadNotifs;

        const readItems = readNotifs.map(notifs => 
            <tr>
                <td>{notifs.fromUser}</td>
                <td>{notifs.readableDate}</td>
                <td>{notifs.remarks}</td>
                <td><a href="#" style={{textDecoration: 'none' }} onClick={() => this.markAsRead(notifs.notifID)}>Mark as Unread</a></td>
            </tr>
        );

        const unreadItems = unreadNotifs.map(notifs => 
            <tr>
                <td>{notifs.fromUser}</td>
                <td>{notifs.readableDate}</td>
                <td>{notifs.remarks}</td>
                <td><a href="#" style={{textDecoration: 'none' }} onClick={() => this.markAsRead(notifs.notifID)}>Mark as Read</a></td>
            </tr>
        );

        return (
            <div>
                <p><strong>Unread Notifications:</strong></p>
                <br/>
                <table style={{marginLeft: 'auto', marginRight: 'auto'}}>
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>Time Sent</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {unreadItems} 
                    </tbody>
                </table>
                <br/>

                <p><strong>Read Notifications:</strong></p>
                <br/>
                <table style={{marginLeft: 'auto', marginRight: 'auto'}}>
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>Time Sent</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {readItems} 
                    </tbody>
                </table>
                <br/>
            </div>
            

        );
    }
}

if (document.getElementById('notifications-all')) {
    ReactDOM.render(<NotificationsMain />, document.getElementById('notifications-all'));
}
