import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

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
    }

    componentDidMount(){
        this.getThresholds();
    }

    render() {
        const thresholds = this.state.thresholds;
        const thresholdItems = thresholds.map((thresholds) =>
            <tr key={thresholds.name}>
                <td>{thresholds.name}</td>
                <td>{thresholds.value}</td>
            </tr>
        );
        return (
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
        );
    }
}

if (document.getElementById('threshold-control')) {
    ReactDOM.render(<ThresholdsMain />, document.getElementById('threshold-control'));
}
