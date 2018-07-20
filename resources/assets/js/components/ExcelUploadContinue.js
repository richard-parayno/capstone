import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

export default class ExcelUploadInput extends Component {
    constructor() {
        super()
        this.state = {
            successMessage: []
        }
    }

    uploadToDatabase() {
        console.log("Upload props:")
        console.log(this.props.data)

        axios.post('api/trip/process/upload', this.props.data)
            .then(response => {
                response = response.data
                console.log(response)

                this.setState({ 
                    successMessage: "" 
                })
            })
            .catch(error => console.log(error))
    }

   
    render() { 
       
        return (
            <div>
                <button onClick={this.uploadToDatabase.bind(this)} className={"button-primary u-pull-right"}>Confirm Trip Data Upload</button>
            </div>
        ); 
    };

}

