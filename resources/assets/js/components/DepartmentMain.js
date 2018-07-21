import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import Department from './Department';

export default class DepartmentMain extends Component {
    constructor() {
        super();
        this.state = {
            department: [],
        };
    }

    getDepartments() {
        axios.get('api/department')
            .then(department => {
                department=department.data;
                this.setState({ department });
            })
    }

    componentDidMount(){
        this.getDepartments();
    }

    render() {
        return (
            <div>
                <Department department={this.state.department}/>
            </div>   
        );
    }
}

if (document.getElementById('department-table')) {
    ReactDOM.render(<DepartmentMain />, document.getElementById('department-table'));
}
