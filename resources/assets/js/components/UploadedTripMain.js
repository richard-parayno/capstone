import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import UploadedTrip from './UploadedTrip';
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';
import 'react-tabs/style/react-tabs.css';


export default class UploadedTripMain extends Component {
    constructor() {
        super();
        this.state = {
            trip: [],
            institutions: [],
        };
    }

    getTrips() {
        axios.get('api/trip') //all institutions
            .then(trip => {
                trip=trip.data;
                this.setState({ trip });
            })
    }

    getCampusSpecificTrips() {
        axios.get('api/institution')
            .then(institutions => {
                let allInstitutions = institutions.data;
                console.log(allInstitutions);
                this.setState({institutions: allInstitutions});
                allInstitutions.forEach(element => {
                    let institutionID = element['institutionID']; 
                    console.log(institutionID)
                    return axios.post('api/trip/specific', {institutionID: institutionID})
                                .then(trip => {
                                    let stateName = "specific"+institutionID;
                                    trip = trip.data;
                                    this.setState({ [stateName] : trip })
                                })
                });
            })
    }


    componentDidMount(){
        this.getTrips();
        this.getCampusSpecificTrips();
    }

    render() {
        const institutionsList = this.state.institutions;

        const institutionTabs = institutionsList.map((institutions) => 
            <Tab key={institutions.institutionID}>{institutions.institutionName}</Tab>
        );

        

        const institutionPanels = institutionsList.map((institutions) =>{
            let stateName = "specific"+institutions.institutionID;    
            return <TabPanel key={institutions.institutionID}>
                <UploadedTrip trip={this.state[stateName]}/>
            </TabPanel>
        });

        return (
            <div>
                <Tabs forceRenderTabPanel defaultIndex={0}>
                    <TabList>
                        <Tab>All Campuses</Tab>
                        {institutionTabs}
                    </TabList>
                    <TabPanel>
                        <UploadedTrip trip={this.state.trip}/>
                    </TabPanel>
                    {institutionPanels}
                </Tabs>

            </div>
        );
    }
}

if (document.getElementById('uploaded-trip-table')) {
    ReactDOM.render(<UploadedTripMain />, document.getElementById('uploaded-trip-table'));
}
