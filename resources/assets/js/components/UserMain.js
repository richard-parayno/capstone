import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import User from './User';

export default class UserMain extends Component {
    constructor() {
        super();
        this.state = {
            users: [],
        };
    }

    getUsers() {
        axios.get('api/users')
            .then(users => {
                users=users.data;

                this.setState({ users });
            })
    }

    componentDidMount(){
        this.getUsers();
    }

    render() {
        return (
            <div>
                <User users={this.state.users}/>
            </div>   
        );
    }
}

if (document.getElementById('user-table')) {
    ReactDOM.render(<UserMain />, document.getElementById('user-table'));
}
