import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

export default class ThresholdsMain extends Component {
    constructor() {
        super();
        this.state = {
            thresholds: [],
        };
    }

    getThresholds() {
        axios.get('api/thresholds')
            .then(thresholds => {
                thresholds=thresholds.data;
                this.setState({ thresholds });
            })
            .catch((error) => {
                // Error
                if (error.response.status == 422) {
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    // console.log(error.response.status);
                    // console.log(error.response.headers);
                    this.setState({ errorMessages: error.response.data.errors });
                    if (this.state.errorMessages.deptName) {
                        toast.error(this.state.errorMessages.deptName[0], {
                            position: toast.POSITION.TOP_RIGHT,
                            autoClose: false
                        })
                    }
                    if (this.state.errorMessages.institutionID) {
                        toast.error(this.state.errorMessages.institutionID[0], {
                            position: toast.POSITION.TOP_RIGHT,
                            autoClose: false
                        })
                    }
                    if (this.state.errorMessages.motherDeptID) {
                        toast.error(this.state.errorMessages.motherDeptID[0], {
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

    componentDidMount(){
        this.getThresholds();
    }

    handleSubmit(event) {
        event.preventDefault();
        const data = new FormData(event.target);

        axios.post('api/thresholds/update', data)
            .then((response) => {
                let updated = response.data;
                toast.success("🎉 Thresholds Updated!", {
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

    render() {
        const thresholds = this.state.thresholds;
        const thresholdItems = thresholds.map((thresholds) =>
            <tr key={thresholds.name}>
                <td>{thresholds.name}</td>
                <td>{thresholds.value}</td>
            </tr>
        );
        const thresholdInputs = thresholds.map((thresholds) =>
            <div className="twelve columns" key={thresholds.name}>
                <label htmlFor={(thresholds.name).toLowerCase()+"Threshold"}>Update {thresholds.name} Threshold</label>
                <input className="u-full-width" type="number" step="any" name={(thresholds.name).toLowerCase()+"Threshold"} id={(thresholds.name).toLowerCase()+"Threshold"} defaultValue={thresholds.value} />
            </div>                
        );
        return (
            <div>
                <div>
                    <table style={{marginLeft: 'auto', marginRight: 'auto'}}>
                        <thead>
                            <tr>
                                <th>Threshold Type</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            {thresholdItems}  
                        </tbody>
                    </table>
                </div>
                <div>
                    <form id="thresholdInputs" name="thresholdInputs" onSubmit={this.handleSubmit}>
                        {thresholdInputs}
                        <div className="twelve columns">
                            <input type="submit" className="button-primary u-pull-right" />
                        </div>
                    </form>
                </div>
                    <ToastContainer autoClose={1000} />                

            </div>   
        );
    }
}

if (document.getElementById('threshold-control')) {
    ReactDOM.render(<ThresholdsMain />, document.getElementById('threshold-control'));
}
