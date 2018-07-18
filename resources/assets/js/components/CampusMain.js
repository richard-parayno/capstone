import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import Campus from './Campus';

export default class CampusMain extends Component {
    constructor() {
        super();
        this.state = {
            institution: [],
        };
    }

    getInstitutions() {
        axios.get('api/institution')
            .then(institution => {
                institution=institution.data;
                this.setState({ institution });
            })
    }

    componentDidMount(){
        this.getInstitutions();
    }

    render() {
        return (
            <div>
                <h1>Manage Campuses</h1>
                <Campus institutions={this.state.institution}/>
            </div>   
        );
    }
}

if (document.getElementById('campus-table-dom')) {
    ReactDOM.render(<CampusMain />, document.getElementById('campus-table-dom'));
}
