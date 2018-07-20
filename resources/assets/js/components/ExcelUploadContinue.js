import React, { Component } from 'react';
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

export default class ExcelUploadInput extends Component {
    uploadToDatabase() {
        console.log("Upload props:")
        console.log(this.props.data)

        axios.post('api/trip/process/upload', this.props.data)
            .then(response => {
                response = response.data
                console.log(response)

                toast.success("🎉 Trip Data Upload Complete!", {
                    position: toast.POSITION.TOP_RIGHT
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

