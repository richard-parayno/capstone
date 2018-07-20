import React, { Component } from 'react';
import ReactTable from "react-table";
import matchSorter from 'match-sorter'


export default class ExcelUploadConfirmTable extends Component {

    render() {
        const data = this.props.data;

        const columns = [{
            Header: 'Date',
            id: 'Date',
            accessor: 'Date', // String-based value accessors!
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['Date'] }),
            filterAll: true
          }, {
            Header: 'Departure Time',
            id: 'Departure Time',
            accessor: 'Departure Time', // String-based value accessors!
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['Departure Time'] }),
            filterAll: true
          }, {
            Header: 'Destinations',
            id: 'Destinations',
            accessor: 'Destinations', // String-based value accessors!
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['Destinations'] }),
            filterAll: true
          }, {
            Header: 'Kilometer Reading',
            id: 'Kilometer Reading',
            accessor: 'Kilometer Reading',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['Kilometer Reading'] }),
            filterAll: true
          }, {
            Header: 'Plate Number',
            id: 'Plate Number',
            accessor: 'Plate Number',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['Plate Number'] }),
            filterAll: true,
            getProps: (state, rowInfo) => {
                if(rowInfo)
                    return {
                        style: {
                            backgroundColor: (rowInfo.original.plateNull === true ? 'red' : 'white')
                        }
                    }
                else {
                    return {

                    }
                }
            }
          }, {
            Header: 'Requesting Department',
            id: 'Requesting Department',
            accessor: 'Requesting Department',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['Requesting Department'] }),
            filterAll: true,
            getProps: (state, rowInfo) => {
                //console.log(rowInfo)
                if(rowInfo)
                    return {
                        style: {
                            backgroundColor: (rowInfo.original.deptNull === true ? 'red' : 'white')
                        }
                    }
                else {
                    return {
                        
                    }
                }
            }
          }]; 
          
        //console.log("Data")        
        //console.log(data)
    
        return (
            
            <ReactTable
                minRows={5}
                pageSize={5}
                filterable
                defaultFilterMethod={(filter, row) =>
                    String(row[filter.id]) === filter.value}
                data={data}
                columns={columns}
                className="-striped -highlight"
                defaultSorted={[
                    {
                        id: 'date',
                        desc: false
                    }
                ]}
                />
        );
    }
}
